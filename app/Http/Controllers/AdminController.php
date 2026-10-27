<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\password_reset_table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\DivorceApplication;
use App\Models\NikkahApplication;
use App\Models\ConvertApplication;
use App\Models\GuardianshipApplication;
use App\Models\InheritanceApplication;
use App\Services\AccessControl;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        // INHERITANCE
        $totalInheritance = AccessControl::scopeApplications(InheritanceApplication::query())->count();
        $pendingInheritance = AccessControl::scopeApplications(InheritanceApplication::query())->where('status', 'submitted')->count();
        $thisMonthInheritance = AccessControl::scopeApplications(InheritanceApplication::query())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // NIKAH
        $totalNikah = AccessControl::scopeApplications(NikkahApplication::query())->count();
        $pendingNikah = AccessControl::scopeApplications(NikkahApplication::query())->where('status', 'submitted')->count();
        $approvedTodayNikah = AccessControl::scopeApplications(NikkahApplication::query())->whereDate('updated_at', now())->where('status', 'approved')->count();

        // DIVORCE (if needed for right-side card later)
        $totalDivorce = AccessControl::scopeApplications(DivorceApplication::query())->count();
        $pendingDivorce = AccessControl::scopeApplications(DivorceApplication::query())->where('status', 'submitted')->count();
        $approvedTodayDivorce = AccessControl::scopeApplications(DivorceApplication::query())->whereDate('updated_at', now())->where('status', 'approved')->count();

        // Optional: Current period (this month)
        $currentMonthInheritance = AccessControl::scopeApplications(InheritanceApplication::query())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Previous cards
        $currentMonthNikah = AccessControl::scopeApplications(NikkahApplication::query())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $currentMonthCases = $currentMonthNikah;

        $totalConverts = AccessControl::scopeApplications(ConvertApplication::query())->count();
        $pendingConverts = AccessControl::scopeApplications(ConvertApplication::query())->where('status', 'pending')->count();
        $thisMonthConverts = AccessControl::scopeApplications(ConvertApplication::query())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalGuardianships = AccessControl::scopeApplications(GuardianshipApplication::query())->count();
        $pendingGuardianships = AccessControl::scopeApplications(GuardianshipApplication::query())->where('status', 'pending')->count();
        $activeGuardianships = AccessControl::scopeApplications(GuardianshipApplication::query())->where('status', 'active')->count();


        return view('admin.dashboard', compact(
            'totalInheritance',
            'pendingInheritance',
            'thisMonthInheritance',
            'totalNikah',
            'pendingNikah',
            'approvedTodayNikah',
            'totalDivorce',
            'pendingDivorce',
            'approvedTodayDivorce',
            'currentMonthCases',
            'currentMonthNikah',
            'currentMonthInheritance',
            'totalConverts',
            'pendingConverts',
            'thisMonthConverts',
            'totalGuardianships',
            'pendingGuardianships',
            'activeGuardianships',
        ));
    }

    public function userProfile()
    {
        $admin = DB::table('users')->where('id', Session('LoggedAdmin'))->first();

        return view('admin.profile', compact(['admin']));
    }

    public function userLogin()
    {
        return view('admin.login');
    }

    public function addAdmin()
    {
        return view('admin.add-admin');
    }

    public function addAdmins()
    {
        $admins = User::where('user_role', 1)->get();
        return view('admin.all-admins', compact('admins'));
    }

    public function forgotPassword()
    {
        return view('admin.forgot-password');
    }

    public function editAdmin(User $admin)
    {
        return response()->json($admin);
    }


    public function updateAdmin(Request $request, User $admin)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $admin->id,
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'phonenumber' => 'required|string|max:20',
            'country' => 'required|in:Kenya,Uganda,Tanzania,Rwanda,Burundi',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $admin->update($request->only([
            'firstname',
            'lastname',
            'username',
            'email',
            'phonenumber',
            'country',
            'gender'
        ]));

        return response()->json(['status' => true, 'message' => 'Admin updated successfully!']);
    }


    public function destroy($id)
    {
        $admin = User::where('user_role', 1)->findOrFail($id);
        $admin->delete();

        return response()->json(['success' => true]);
    }

    public function changeStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:0,8,9,10'
        ]);

        $admin = User::where('user_role', 1)->findOrFail($id);
        $admin->account_status = $validated['status'];
        $admin->save();

        return response()->json(['message' => 'Account status updated.']);
    }


    public function checkUser(Request $request)
    {

        $emailOrUsername = $request->input('email');

        $isEmail = str_contains($emailOrUsername, '@');

        $rules = [
            'email' => ['required'],
            'password' => [
                'required',
                // 'string',
                // 'min:8',
                // 'regex:/[a-z]/',
                // 'regex:/[A-Z]/',
                // 'regex:/\d/',
                // 'regex:/[\W_]/',
            ],
        ];

        // If it's an email, apply email format validation
        if ($isEmail) {
            $rules['email'][] = 'email';
            $rules['email'][] = 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        }

        $request->validate($rules);

        $userInfo = User::where($isEmail ? 'email' : 'username', $emailOrUsername)->first();

        if (!$userInfo) {

            Helper::auditTrail('Login Failed', 'User', Session::get('LoggedAdmin'), 'fail', ['status' => 'Failed Login'], ['status' => 'Failed'], 'We don’t recognize the provided credentials.');

            return response()->json([
                'status' => false,
                'message' => 'We don’t recognize the provided credentials.',
            ]);
        }

        if (!Hash::check($request->password, $userInfo->password)) {
            Helper::auditTrail('Login Failed', 'User', Session::get('LoggedAdmin'), 'fail', ['status' => 'Failed Login'], ['status' => 'Failed'], 'Invalid password or credentials.');
            return response()->json([
                'status' => false,
                'message' => 'Invalid password or credentials.',
            ]);
        }

        $statusMessages = [
            0 => 'Your account has been banned.',
            8 => 'Your account is locked.',
            9 => 'Your account is suspended.',
        ];

        if ($userInfo->account_status != 10) {
            Helper::auditTrail('Login Failed', 'User', Session::get('LoggedAdmin'), 'fail', ['status' => 'Failed Login'], ['status' => 'Failed'], 'Your account is not active.');

            $message = $statusMessages[$userInfo->account_status] ?? 'Your account is not active.';

            return response()->json([
                'status' => false,
                'message' => $message,
            ]);
        }

        // Only accounts holding a valid, recognised role on the system
        // (Imaam, County Sheikh, District Khadhi, Director for Sharia, or a
        // custom role created from Roles & Privileges) may log in. A
        // "normal person" with no role assigned is rejected here.
        if (!$userInfo->role_id) {
            Helper::auditTrail('Login Failed', 'User', $userInfo->id, 'fail', ['status' => 'Failed Login'], ['status' => 'Failed'], 'Account has no assigned role.');

            return response()->json([
                'status' => false,
                'message' => 'Your account does not have system access. Please contact the Directorate for Sharia.',
            ]);
        }

        Session::put('LoggedAdmin', $userInfo->id);
        $userInfo->forceFill(['last_login_at' => now()])->save();

        Helper::auditTrail('Login Successful', 'User', $userInfo->id, 'success', ['status' => 'Login Successful'], ['status' => 'Approved'], 'User Login Successful.');

        $redirectUrl = '/users/dashboard';

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'redirect_url' => $redirectUrl,
        ]);
    }


    public function flushSession()
    {
        session()->flush();
        return redirect('/');
    }


    public function userLogout()
    {
        if (session()->has('LoggedAdmin')) {
            session()->flush();
            return redirect('/');
        } else {
            return redirect('/');
        }
    }


    public function storeAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6',
            'phonenumber' => 'required|string|max:20',
            'country' => 'required|string|in:Kenya,Uganda,Tanzania,Rwanda,Burundi',
            'gender' => 'nullable|in:male,female,other',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phonenumber' => $request->phonenumber,
            'country' => $request->country,
            'gender' => $request->gender,
            'user_role' => 1, // Admin
            'account_status' => 10,
            'registration_status' => 1,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Admin created successfully!',
        ]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'newPassword' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[^a-zA-Z0-9]/'
            ],
            'confirmPassword' => 'required|same:newPassword'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $adminId = session('LoggedAdmin');
        $user = \App\Models\User::find($adminId);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ], 404);
        }

        $user->password = Hash::make($request->newPassword);
        $user->must_change_password = false;
        $user->save();

        Helper::auditTrail('Password Changed', 'User', $user->id, 'success', null, null, "{$user->full_name} changed their password.");

        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully.',
            'redirect_url' => '/users/dashboard',
        ]);
    }

    /**
     * Forced password-change screen shown to accounts created via Bulk
     * Import (or reset by an administrator) before they can use the rest
     * of the system.
     */
    public function forcePasswordChange()
    {
        $user = User::find(session('LoggedAdmin'));

        if (!$user || !$user->must_change_password) {
            return redirect('/users/dashboard');
        }

        return view('admin.force-password-change', compact('user'));
    }

    /**
     * Used by the "Update Your Login Credentials" popup shown on the
     * dashboard to any account still using a system-generated password
     * (e.g. created via Bulk Import). Lets the user pick their own username
     * and password in one step; clears the plain-text generated_password
     * so Manage Users now shows "Updated" instead of the old password.
     */
    public function updateCredentials(Request $request)
    {
        $userId = session('LoggedAdmin');
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'alpha_dash',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'newPassword' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[^a-zA-Z0-9]/',
            ],
            'confirmPassword' => 'required|same:newPassword',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user->username = $request->username;
        $user->password = Hash::make($request->newPassword);
        $user->must_change_password = false;
        $user->generated_password = null;
        $user->save();

        Helper::auditTrail(
            'Credentials Updated',
            'User',
            $user->id,
            'success',
            null,
            ['username' => $user->username],
            "{$user->full_name} updated their login credentials."
        );

        return response()->json([
            'status' => true,
            'message' => 'Your login credentials have been updated successfully.',
        ]);
    }

    public function generateForgotPasswordLink(Request $request)
    {
        // Validate email
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'The email provided is not registered in the system.',
        ]);

        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withInput()->with('fail', 'The email provided is not registered in the system.');
        }

        $token = Str::random(60);
        $resetUrl = url('password/reset', $token);

        $post = new password_reset_table();
        $post->email = $email;
        $post->token = $resetUrl;
        $post->created_at = now();
        $post->save();

        $data = [
            'email' => $email,
            'username' => $user->username,
            'resetUrl' => $resetUrl,
            'title' => Helper::app_name() . ' : Reset Password Link',
        ];

        Mail::send('emails.reset_email', $data, function ($message) use ($data) {
            $message->to($data['email'])->subject($data['title']);
        });

        return back()->with('success', 'A password reset link has been sent to your email: ' . $email);
    }

    public function createNewPassword($id)
    {
        $generated_id = url('password/reset/' . $id);
        $resetEntry = DB::table('password_reset_tables')->where('token', $generated_id)->first();

        if ($resetEntry) {
            if ($resetEntry->link_status == 0) {
                if (now()->diffInMinutes($resetEntry->created_at) <= 30) {
                    return view('admin.reset-password-2', compact(['generated_id']));
                } else {
                    return redirect()->route('reset-password-access-link')->with('fail', 'This reset password link has expired');
                }
            } else {
                return redirect()->route('reset-password-access-link')->with('fail', 'This link has already been used, request for a new link');
            }
        } else {

            return redirect()->route('reset-password-access-link')->with('fail', 'Invalid link');
        }
    }

    public function store_new_password(Request $request)
    {
        $request->validate(
            [
                'password' => [
                    'required',
                    'string',
                    'min:6',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*?&#]/',
                    'confirmed'
                ],
            ],
            [
                'password.required' => 'The password field is required.',
                'password.string' => 'The password must be a string.',
                'password.min' => 'The password must be at least 6 characters.',
                'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
                'password.confirmed' => 'Passwords do not match.'
            ],
        );


        $password = $request->password;
        $confirm = $request->password_confirmation;
        $generated_id = $request->generated_id;

        if ($password == $confirm) {

            $record = DB::table('password_reset_tables')->where('token', $generated_id)->first();
            $record_id = $record->id;
            $user_email = $record->email;

            $new_password = Hash::make($password);

            DB::table('users')
                ->where('email', $user_email)
                ->update(['password' => $new_password]);

            $post = password_reset_table::find($record_id);
            $post->link_status = 1;
            $post->save();

            $user = DB::table('users')
                ->where('email', $user_email)
                ->first();

            if ($user->registration_status == 0) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['registration_status' => 1]);
            }


            return redirect()->route('user.login')->with('success', 'Password has been updated successfully');
        } else {
            return back()->with('fail', 'Passwords do not match');
        }
    }

    public function allCertifcates()
    {
        $allCertificates = DB::table('nikkah_applications')->orderBy('created_at', 'desc')->get();

        return view('admin.all-certificates', compact('allCertificates'));
    }
}