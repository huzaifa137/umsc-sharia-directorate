<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Every permission slug recognised by the system, grouped by module so
     * the Roles & Privileges screen can render them as clean checkbox groups.
     */
    protected function permissionCatalogue(): array
    {
        $caseModules = [
            'nikah' => 'Nikah',
            'divorce' => 'Divorce',
            'inheritance' => 'Inheritance',
            'guardianship' => 'Guardianship',
            'convert' => 'Converts',
        ];

        $permissions = [];

        foreach ($caseModules as $slug => $label) {
            $permissions[] = ['name' => "View {$label} Applications", 'slug' => "{$slug}.view", 'module' => $label, 'action' => 'view'];
            $permissions[] = ['name' => "Register New {$label}", 'slug' => "{$slug}.create", 'module' => $label, 'action' => 'create'];
            $permissions[] = ['name' => "Edit {$label} Applications", 'slug' => "{$slug}.edit", 'module' => $label, 'action' => 'edit'];
            $permissions[] = ['name' => "Approve / Reject {$label}", 'slug' => "{$slug}.approve", 'module' => $label, 'action' => 'approve'];
            $permissions[] = ['name' => "Delete {$label} Applications", 'slug' => "{$slug}.delete", 'module' => $label, 'action' => 'delete'];
        }

        $permissions = array_merge($permissions, [
            ['name' => 'View User Accounts', 'slug' => 'users.view', 'module' => 'User Management', 'action' => 'view'],
            ['name' => 'Create User Accounts', 'slug' => 'users.create', 'module' => 'User Management', 'action' => 'create'],
            ['name' => 'Edit User Accounts', 'slug' => 'users.edit', 'module' => 'User Management', 'action' => 'edit'],
            ['name' => 'Suspend / Unsuspend Accounts', 'slug' => 'users.suspend', 'module' => 'User Management', 'action' => 'suspend'],
            ['name' => 'Ban Accounts', 'slug' => 'users.ban', 'module' => 'User Management', 'action' => 'ban'],
            ['name' => 'Delete Accounts', 'slug' => 'users.delete', 'module' => 'User Management', 'action' => 'delete'],

            ['name' => 'View Roles & Privileges', 'slug' => 'roles.view', 'module' => 'Roles & Privileges', 'action' => 'view'],
            ['name' => 'Manage Roles & Privileges', 'slug' => 'roles.manage', 'module' => 'Roles & Privileges', 'action' => 'manage'],

            ['name' => 'Access Bulk Import', 'slug' => 'bulk_import.view', 'module' => 'Bulk Import', 'action' => 'view'],
            ['name' => 'Run Bulk Import', 'slug' => 'bulk_import.run', 'module' => 'Bulk Import', 'action' => 'run'],

            ['name' => 'View Activity Logs', 'slug' => 'activity_logs.view', 'module' => 'Activity Logs', 'action' => 'view'],

            // --- Chat -------------------------------------------------
            ['name' => 'View Chat', 'slug' => 'chat.view', 'module' => 'Chat', 'action' => 'view', 'description' => 'Access the internal staff chat module.'],
            ['name' => 'Start Chats', 'slug' => 'chat.create', 'module' => 'Chat', 'action' => 'create', 'description' => 'Start new direct chats and create groups.'],

            // --- Certificates -------------------------------------------
            // Deliberately NOT attached to any role below — only the
            // Director (full_access) can access the Certificates module
            // unless you explicitly grant this from Roles & Privileges.
            ['name' => 'View Certificates Module', 'slug' => 'certificates.view', 'module' => 'Certificates', 'action' => 'view', 'description' => 'Search, preview, edit, and print certificates across every module.'],

            // --- Fatwa (Islamic Rulings) -------------------------------
            // Deliberately NOT attached to Imaam/County Sheikh/District
            // Khadhi below — only the Director (full_access) can manage
            // fatwas unless you explicitly grant these from Roles & Privileges.
            ['name' => 'View Fatwa Management', 'slug' => 'fatwa.view', 'module' => 'Fatwa', 'action' => 'view', 'description' => 'Access the Fatwa management screen.'],
            ['name' => 'Publish New Fatwa', 'slug' => 'fatwa.create', 'module' => 'Fatwa', 'action' => 'create', 'description' => 'Create and publish new Islamic rulings.'],
            ['name' => 'Edit Fatwa', 'slug' => 'fatwa.edit', 'module' => 'Fatwa', 'action' => 'edit', 'description' => 'Edit existing Islamic rulings.'],
            ['name' => 'Delete Fatwa', 'slug' => 'fatwa.delete', 'module' => 'Fatwa', 'action' => 'delete', 'description' => 'Delete Islamic rulings.'],
        ]);

        return $permissions;
    }

    public function run(): void
    {
        foreach ($this->permissionCatalogue() as $perm) {
            Permission::updateOrCreate(['slug' => $perm['slug']], $perm);
        }

        $caseModuleSlugs = ['nikah', 'divorce', 'inheritance', 'guardianship', 'convert'];

        // ---------------------------------------------------------------
        // Imaam — registers cases, sees only what he personally created.
        // ---------------------------------------------------------------
        $imaam = Role::updateOrCreate(
            ['slug' => 'imaam'],
            [
                'name' => 'Imaam',
                'description' => 'Mosque Imaam. Registers Nikah, Divorce, Inheritance, Guardianship and Convert cases and can only see the records he personally created.',
                'data_scope' => 'self',
                'level' => 10,
                'is_system' => true,
                'full_access' => false,
                'color' => '#0d9b6c',
                'icon' => 'bx-user-check',
            ]
        );

        $imaamPermissions = collect($caseModuleSlugs)
            ->flatMap(fn ($m) => ["{$m}.view", "{$m}.create", "{$m}.edit"])
            ->merge(['chat.view', 'chat.create'])
            ->all();

        // ---------------------------------------------------------------
        // County Sheikh — same case permissions, county-wide visibility.
        // ---------------------------------------------------------------
        $countySheikh = Role::updateOrCreate(
            ['slug' => 'county_sheikh'],
            [
                'name' => 'County Sheikh',
                'description' => 'Oversees the Imaams within a county. Can register cases and view everything registered in his county.',
                'data_scope' => 'county',
                'level' => 20,
                'is_system' => true,
                'full_access' => false,
                'color' => '#0f7d4e',
                'icon' => 'bx-buildings',
            ]
        );

        $countySheikhPermissions = collect($caseModuleSlugs)
            ->flatMap(fn ($m) => ["{$m}.view", "{$m}.create", "{$m}.edit", "{$m}.approve"])
            ->merge(['users.view', 'chat.view', 'chat.create'])
            ->all();

        // ---------------------------------------------------------------
        // District Khadhi — county sheikh's permissions, district-wide
        // visibility, plus the ability to create/manage Imaam accounts
        // within his own district (not County Sheikh — see
        // AccessControl::CREATABLE_ROLES for the exact who-creates-whom map).
        // ---------------------------------------------------------------
        $districtKhadhi = Role::updateOrCreate(
            ['slug' => 'district_khadhi'],
            [
                'name' => 'District Khadhi',
                'description' => 'Oversees every County Sheikh and Imaam within a district. Sees every case registered in the district and can onboard new Imaam accounts.',
                'data_scope' => 'district',
                'level' => 30,
                'is_system' => true,
                'full_access' => false,
                'color' => '#00580f',
                'icon' => 'bx-landscape',
            ]
        );

        $districtKhadhiPermissions = collect($caseModuleSlugs)
            ->flatMap(fn ($m) => ["{$m}.view", "{$m}.create", "{$m}.edit", "{$m}.approve", "{$m}.delete"])
            ->merge([
                'users.view', 'users.create', 'users.edit', 'users.suspend', 'users.ban',
                'activity_logs.view', 'chat.view', 'chat.create',
            ])
            ->all();

        // ---------------------------------------------------------------
        // Regional Assistant — sits between the District Khadhi and the
        // Director for Sharia. Oversees every District Khadhi, County
        // Sheikh, and Imaam within a region (a grouping of districts),
        // the same way a District Khadhi oversees a single district.
        // ---------------------------------------------------------------
        $regionalAssistant = Role::updateOrCreate(
            ['slug' => 'regional_assistant'],
            [
                'name' => 'Regional Assistant',
                'description' => 'Assists the Director for Sharia. Oversees every District Khadhi, County Sheikh, and Imaam within a region, sees every case registered across that region, and can onboard new County Sheikh and Imaam accounts.',
                'data_scope' => 'region',
                'level' => 40,
                'is_system' => true,
                'full_access' => false,
                'color' => '#5b2a86',
                'icon' => 'bx-map-alt',
            ]
        );

        $regionalAssistantPermissions = collect($caseModuleSlugs)
            ->flatMap(fn ($m) => ["{$m}.view", "{$m}.create", "{$m}.edit", "{$m}.approve", "{$m}.delete"])
            ->merge([
                'users.view', 'users.create', 'users.edit', 'users.suspend', 'users.ban',
                'activity_logs.view', 'chat.view', 'chat.create',
            ])
            ->all();

        // ---------------------------------------------------------------
        // Director for Sharia — full, unrestricted access to everything,
        // including the Roles & Privileges and Bulk Import modules.
        // ---------------------------------------------------------------
        $director = Role::updateOrCreate(
            ['slug' => 'director'],
            [
                'name' => 'Director for Sharia',
                'description' => 'Responsible for everything and everyone on the system. Full access to every module, every record, and every account.',
                'data_scope' => 'global',
                'level' => 100,
                'is_system' => true,
                'full_access' => true,
                'color' => '#7a1fa2',
                'icon' => 'bx-crown',
            ]
        );

        $this->syncPermissions($imaam, $imaamPermissions);
        $this->syncPermissions($countySheikh, $countySheikhPermissions);
        $this->syncPermissions($districtKhadhi, $districtKhadhiPermissions);
        $this->syncPermissions($regionalAssistant, $regionalAssistantPermissions);

        // The Director has full_access = true so AccessControl bypasses
        // permission checks entirely, but we still attach every permission
        // record so the Roles & Privileges screen displays an accurate,
        // fully-checked matrix for this role.
        $director->permissions()->sync(Permission::pluck('id'));
    }

    protected function syncPermissions(Role $role, array $slugs): void
    {
        $ids = Permission::whereIn('slug', $slugs)->pluck('id', 'slug');
        $role->permissions()->sync($ids->values());
    }
}