<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Services\AccessControl;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Roles & Privileges landing page — lists every role the current user is
     * allowed to see (full-access roles see everything; everyone else only
     * sees roles ranked below their own, matching who they're allowed to
     * create accounts for) together with the full permission catalogue,
     * grouped by module, for the create/edit modal.
     */
    public function index()
    {
        $me = AccessControl::user();

        $roles = AccessControl::hasFullAccess()
            ? Role::with('permissions')->withCount('users')->orderByDesc('level')->get()
            : Role::with('permissions')->withCount('users')
                ->where('level', '<', $me->role?->level ?? 0)
                ->orderByDesc('level')->get();

        $permissions = Permission::orderBy('module')->orderBy('action')->get()->groupBy('module');

        return view('admin.roles-privileges', compact('roles', 'permissions'));
    }

    /**
     * Create a brand new role. Only reachable by accounts holding
     * `roles.manage` — a District Khadhi may, for example, define a
     * specialised role for one of his Imaams, as long as its level ranks
     * below his own.
     */
    public function store(Request $request)
    {
        $me = AccessControl::user();

        $data = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
            'description' => 'nullable|string|max:500',
            'data_scope' => 'required|in:self,county,district,region,global',
            'level' => 'required|integer|min:1|max:99', // 100 (full access) is reserved for the Director
            'color' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:60',
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        // Non-full-access users may only mint roles ranked strictly below
        // their own, and may only hand out a "global" scope to roles below
        // the Director.
        if (!AccessControl::hasFullAccess()) {
            $myLevel = $me->role?->level ?? 0;

            if ($data['level'] >= $myLevel) {
                return response()->json([
                    'status' => false,
                    'message' => 'You can only create roles ranked below your own.',
                ], 403);
            }

            if ($data['data_scope'] === 'global') {
                return response()->json([
                    'status' => false,
                    'message' => 'Only the Director for Sharia can grant system-wide visibility.',
                ], 403);
            }
        }

        $role = Role::create([
            'name' => $data['name'],
            'slug' => \Illuminate\Support\Str::slug($data['name'], '_'),
            'description' => $data['description'] ?? null,
            'data_scope' => $data['data_scope'],
            'level' => $data['level'],
            'is_system' => false,
            'full_access' => false,
            'color' => $data['color'] ?? '#00580f',
            'icon' => $data['icon'] ?? 'bx-shield',
            'created_by' => $me->id,
        ]);

        $role->permissions()->sync($data['permissions'] ?? []);

        Helper::auditTrail('Role Created', 'Role', $role->id, 'success', null, $data, "Created role \"{$role->name}\".");

        return response()->json([
            'status' => true,
            'message' => 'Role created successfully.',
            'role' => $role->load('permissions'),
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $me = AccessControl::user();

        if (!AccessControl::hasFullAccess() && $role->level >= ($me->role?->level ?? 0)) {
            return response()->json(['status' => false, 'message' => 'You cannot edit a role ranked at or above your own.'], 403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('roles', 'name')->ignore($role->id)],
            'description' => 'nullable|string|max:500',
            'data_scope' => 'required|in:self,county,district,region,global',
            'level' => 'required|integer|min:1|max:99',
            'color' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:60',
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        if ($role->is_system) {
            // System roles (Imaam, County Sheikh, District Khadhi, Director)
            // keep their name, scope and level fixed so the hierarchy rules
            // described to the Director stay intact — only their permission
            // set can be fine-tuned.
            $role->permissions()->sync($data['permissions'] ?? []);

            Helper::auditTrail('Role Permissions Updated', 'Role', $role->id, 'success', null, $data, "Updated privileges for \"{$role->name}\".");

            return response()->json([
                'status' => true,
                'message' => 'Privileges updated successfully.',
                'role' => $role->fresh('permissions'),
            ]);
        }

        if (!AccessControl::hasFullAccess()) {
            $myLevel = $me->role?->level ?? 0;

            if ($data['level'] >= $myLevel) {
                return response()->json(['status' => false, 'message' => 'You can only assign a level below your own.'], 403);
            }
        }

        $role->update([
            'name' => $data['name'],
            'slug' => \Illuminate\Support\Str::slug($data['name'], '_'),
            'description' => $data['description'] ?? null,
            'data_scope' => $data['data_scope'],
            'level' => $data['level'],
            'color' => $data['color'] ?? $role->color,
            'icon' => $data['icon'] ?? $role->icon,
        ]);

        $role->permissions()->sync($data['permissions'] ?? []);

        Helper::auditTrail('Role Updated', 'Role', $role->id, 'success', null, $data, "Updated role \"{$role->name}\".");

        return response()->json([
            'status' => true,
            'message' => 'Role updated successfully.',
            'role' => $role->fresh('permissions'),
        ]);
    }

    public function destroy(Role $role)
    {
        if ($role->is_system) {
            return response()->json(['status' => false, 'message' => 'System roles cannot be deleted.'], 403);
        }

        if ($role->users()->count() > 0) {
            return response()->json([
                'status' => false,
                'message' => 'This role still has accounts assigned to it. Reassign those accounts before deleting it.',
            ], 422);
        }

        $name = $role->name;
        $role->delete();

        Helper::auditTrail('Role Deleted', 'Role', $role->id, 'success', null, null, "Deleted role \"{$name}\".");

        return response()->json(['status' => true, 'message' => 'Role deleted successfully.']);
    }
}
