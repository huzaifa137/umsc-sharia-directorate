<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FatwaController;
use App\Http\Controllers\FatwaAdminController;
use App\Http\Controllers\BulkImportController;

use App\Http\Controllers\ConsultancyController;


use Illuminate\Support\Facades\Hash;

Route::get('/hash-password', function () {
    // Hash the password
    $hashedPassword = Hash::make('Pa$$w0rd!');

    // Use dd() to dump and die, showing the hashed password
    dd($hashedPassword);
});


Route::middleware([\Illuminate\Cookie\Middleware\EncryptCookies::class, \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class, \Illuminate\Session\Middleware\StartSession::class, \App\Http\Middleware\SetLocale::class])->group(function () {

    Route::get('lang/{locale}', function ($locale) {
        $available = ['en', 'sw', 'ar'];
        if (in_array($locale, $available)) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }
        $back = url()->previous();
        if ($back) {
            return redirect()->to($back);
        }
        return redirect()->route('landing.index');
    })->name('lang.switch');
});

Route::get('/time-test', function () {
    dd(now()->toDateTimeString(), config('app.timezone'));
});

// Fatwa — public, no login required. Anyone visiting the site can read
// published Islamic rulings; only the Director can create/edit them
// (see the fatwa-admin routes further down, inside the AdminAuth group).
Route::get('/fatwa', [FatwaController::class, 'index'])->name('fatwa.public.index');
Route::get('/fatwa/{fatwa:slug}', [FatwaController::class, 'show'])->name('fatwa.public.show');



Route::controller(AdminController::class)->group(function () {

    Route::group(['middleware' => ['AdminAuth']], function () {
        Route::group(['prefix' => '/users'], function () {

            Route::get('add-admin', 'addAdmin')->name('add.admin');
            Route::get('all-admins', 'addAdmins')->name('all.admins');
            Route::get('dashboard', 'adminDashboard')->name('user.dashboard');
            Route::get('login', 'userLogin')->name('user.login');
            Route::get('profile', 'userProfile')->name('user.profile');
            Route::get('/forgot-password', 'forgotPassword')->name('forgot-password');
            Route::get('/change-password', 'forcePasswordChange')->name('force-password-change');

            Route::delete('/admin/{id}', 'destroy')->name('admin.destroy');

            Route::put('/admin/{admin}', 'updateAdmin')->name('admin.update');
            Route::post('/store-admin', 'storeAdmin')->name('admin.store');
            Route::post('/admin/{id}/change-status', 'changeStatus')->name('admin.changeStatus');
            Route::post('/admin/change-password', 'changePassword')->name('admin.change.password');
            Route::post('/update-credentials', 'updateCredentials')->name('update.credentials');
        });
    });

    Route::get('/clear-session', 'flushSession');
    Route::get('/reset-password-access-link', 'userLogin')->name('reset-password-access-link');
    Route::get('/user-logout', 'userLogout')->name('user.logout');
    Route::get('/admin/{admin}/edit', 'editAdmin')->name('admin.edit');
    Route::get('/password/reset/{id}', 'createNewPassword')->name('password/reset');

    Route::post('user-store-new-password', 'store_new_password')->name('user-store-new-password');
    Route::post('auth-user-check', 'checkUser')->name('auth-user-check');
    Route::post('user-generate-forgot-password-link', 'generateForgotPasswordLink')->name('user-generate-forgot-password-link');

});


Route::controller(MasterController::class)->group(function () {

    Route::group(['middleware' => ['AdminAuth']], function () {

        Route::get('/', 'landingHomePage')->name('landing.index');
        Route::get('/guardianship-application', 'guardianshipApplication')->name('guardianship.application')->middleware('permission:guardianship.create');
        Route::get('/convert-application', 'convertApplication')->name('convert.application')->middleware('permission:convert.create');

        // Nikah Routes 

        Route::get('nikah-dashboard', 'nikahDashboard')->name('nikah.dashboard')->middleware('permission:nikah.view');
        Route::get('/nikah', 'nikahRegistration')->name('landing.nikah')->middleware('permission:nikah.create');
        Route::get('/nikah/{id}/edit', 'editNikahApplication')->middleware('permission:nikah.edit');
        Route::get('/nikah-applications', 'nikahApplications')->name('nikkah.applications')->middleware('permission:nikah.view');
        Route::get('/nikah/applications/{id}', 'shownikahApplicationInformation')
            ->name('nikah.show')->middleware('permission:nikah.view');

        Route::get('/nikah-status-applications/{statusId}', 'nikahStatusApplications')
            ->name('nikah.status.applications')->middleware('permission:nikah.view');

        Route::get('/certificate/view/{id}', 'viewCertificate')->middleware('permission:nikah.view');

        Route::delete('/nikah/{id}', 'deleteNikahApplication')->middleware('permission:nikah.delete');

        Route::post('/nikah/{id}/update', 'updateNikahApplication')->middleware('permission:nikah.edit');
        Route::post('/applications/{id}/update-status', 'updateNikkahApplicationStatus')->middleware('permission:nikah.approve');
        Route::post('/save-submitted-nikkah-application', 'saveNikahApplication')->name('nikkah.save')->middleware('permission:nikah.create');


        // Divorce Routes 

        Route::get('divorce-dashboard', 'divorceDashboard')->name('divorce.dashboard')->middleware('permission:divorce.view');
        Route::get('/divorce-application', 'divorceApplication')->name('divorce.application')->middleware('permission:divorce.create');
        Route::get('/divorce-status-applications/{statusId}', 'divorceStatusApplications')
            ->name('divorce.status.applications')->middleware('permission:divorce.view');

        Route::get('/divorce/{id}/edit', 'editDivorceApplication')->name('divorce.edit.applications')->middleware('permission:divorce.edit');
        Route::get('/divorce/{id}/view', 'viewDivorceApplication')->name('divorce.view.applications')->middleware('permission:divorce.view');
        Route::get('/divorce/{id}/delete', 'deleteDivorceApplication')->name('divorce.delete.applications')->middleware('permission:divorce.delete');

        Route::get('/nikah/divorce/{id}', 'showdivorceApplicationInformation')
            ->name('nikah.show')->middleware('permission:divorce.view');

        Route::post('/save-submitted-divorce-application', 'saveDivorceApplication')->name('save.divorce.application')->middleware('permission:divorce.create');
        Route::post('/divorce-status-update/{id}', 'updateApplicationStatus')->name('divorce.status.update')->defaults('type', 'divorce')->middleware('permission:divorce.approve');
        Route::post('/save-updated-divorce-application-data', 'saveUpdatedDivorceApplication')->name('save.updated.divorce.application.data')->middleware('permission:divorce.edit');

        Route::get('divorce/{id}/details', 'showDivorceInformation')->middleware('permission:divorce.view');

        Route::get('divorce/{id}/edit-data', 'editDivorceInformation')->middleware('permission:divorce.edit');
        Route::post('divorce/{id}/update', 'updateDivorceInformation')->middleware('permission:divorce.edit');

        Route::post('/divorce/{id}/delete', 'deleteApplication')->middleware('permission:divorce.delete');

        // Inheritance Routes 

        Route::get('/inheritance-application', 'inheritanceApplication')->name('inheritance.application')->middleware('permission:inheritance.create');
        Route::get('inheritance-dashboard', 'inheritanceDashboard')->name('inheritance.dashboard')->middleware('permission:inheritance.view');
        Route::get('/inheritance-status-applications/{statusId}', 'inheritanceStatusApplications')
            ->name('inheritance.status.applications')->middleware('permission:inheritance.view');

        Route::post('/save-inheritance-application', 'saveInheritanceApplication')->name('save.inheritance.application')->middleware('permission:inheritance.create');
        Route::post('/inheritance-status-update/{id}', 'updateApplicationStatus')->name('inheritance.status.update')->defaults('type', 'inheritance')->middleware('permission:inheritance.approve');

        Route::prefix('inheritance')->group(function () {
            Route::get('{id}/details', 'detailsInheritanceApplication')->name('inheritance.details')->middleware('permission:inheritance.view');
            Route::post('{id}/delete', 'deleteInheritanceApplication')->name('inheritance.delete')->middleware('permission:inheritance.delete');

            Route::get('/{id}/information', 'getInheritanceDetails')->middleware('permission:inheritance.view');
            Route::post('/{id}/update', 'updateInheritanceInformation')->name('inheritance.update')->middleware('permission:inheritance.edit');
        });

        // Guardianship Routes 

        Route::get('guardianship-dashboard', 'guardianshipDashboard')->name('guardianship.dashboard')->middleware('permission:guardianship.view');

        Route::get('/guardianship-status-applications/{statusId}', 'guardianshipStatusApplications')
            ->name('guardianship.status.applications')->middleware('permission:guardianship.view');

        Route::post('/save-guardianship-application', 'saveguardianshipApplication')->name('save.guardianship.application')->middleware('permission:guardianship.create');
        Route::post('/guardianship-status-update/{id}', 'updateApplicationStatus')->name('guardianship.status.update')->defaults('type', 'guardianship')->middleware('permission:guardianship.approve');

        Route::prefix('guardianship')->group(function () {

            Route::get('{id}/details', 'getGuardianshipDetails')
                ->name('guardianship.details')->middleware('permission:guardianship.view');

            Route::post('{id}/update', 'updateGuardianshipApplication')
                ->name('guardianship.update')->middleware('permission:guardianship.edit');

            Route::post('{id}/delete', 'deleteGuardianshipApplication')
                ->name('guardianship.delete')->middleware('permission:guardianship.delete');

        });

        // Converts Routes 

        Route::get('/convert-status-applications/{statusId}', 'convertStatusApplications')->name('convert.status.applications')->middleware('permission:convert.view');
        Route::get('convert-dashboard', 'convertDashboard')->name('convert.dashboard')->middleware('permission:convert.view');
        Route::post('/save-convert-application', 'saveconvertApplication')->name('save.convert.application')->middleware('permission:convert.create');
        Route::post('/convert-status-update/{id}', 'updateApplicationStatus')->name('convert.status.update')->defaults('type', 'convert')->middleware('permission:convert.approve');

        Route::get('applications/{application}',  'show')->name('show')->middleware('permission:convert.view');
        Route::put('applications/{application}',  'update')->name('update')->middleware('permission:convert.edit');
        Route::delete('applications/{application}',  'destroy')->name('destroy')->middleware('permission:convert.delete');

        // Users Routes

        Route::get('users-dashboard', 'usersDashboard')->name('users.dashboard')->middleware('permission:users.view');
        Route::get('add-users', 'addUsers')->name('add.users')->middleware('permission:users.create');
        Route::get('manage-users', 'manageUsers')->name('manage.users')->middleware('permission:users.view');
        Route::post('/save-user-application', 'saveNewUser')->name('save.new.user')->middleware('permission:users.create');

        Route::prefix('users')->group(function () {

            Route::get('/{id}', 'showUser');            // Show user
            Route::delete('/{id}', 'deleteUser')->middleware('permission:users.delete');       // Delete user
            Route::post('/{id}/update', 'updateUser')->middleware('permission:users.edit');
            Route::post('/{id}/change-status', 'changeUserStatus')->name('users.change.status')->middleware('permission:users.suspend|users.ban');
        });

        // Roles & Privileges Routes

        Route::prefix('roles')->group(function () {
            Route::get('/', [\App\Http\Controllers\RoleController::class, 'index'])->name('roles.index')->middleware('permission:roles.view');
            Route::post('/', [\App\Http\Controllers\RoleController::class, 'store'])->name('roles.store')->middleware('permission:roles.manage');
            Route::put('/{role}', [\App\Http\Controllers\RoleController::class, 'update'])->name('roles.update')->middleware('permission:roles.manage');
            Route::delete('/{role}', [\App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:roles.manage');
        });

        // Fatwa Management Routes (Director only, in practice — see the
        // permission seeder: fatwa.* is only ever attached to full_access
        // roles unless you deliberately grant it to someone else)

        Route::prefix('fatwa-admin')->group(function () {
            Route::get('/', [FatwaAdminController::class, 'index'])->name('fatwa.admin.index')->middleware('permission:fatwa.view');
            Route::post('/', [FatwaAdminController::class, 'store'])->name('fatwa.admin.store')->middleware('permission:fatwa.create');
            Route::get('/{fatwa:id}/edit', [FatwaAdminController::class, 'edit'])->name('fatwa.admin.edit')->middleware('permission:fatwa.view');
            Route::put('/{fatwa:id}', [FatwaAdminController::class, 'update'])->name('fatwa.admin.update')->middleware('permission:fatwa.edit');
            Route::delete('/{fatwa:id}', [FatwaAdminController::class, 'destroy'])->name('fatwa.admin.destroy')->middleware('permission:fatwa.delete');
            Route::post('/{fatwa:id}/toggle-status', [FatwaAdminController::class, 'toggleStatus'])->name('fatwa.admin.toggle')->middleware('permission:fatwa.edit');
        });

        // Bulk Import Routes
        Route::prefix('bulk-import')->group(function () {
            Route::get('/', [BulkImportController::class, 'index'])->name('bulk-import.index')->middleware('permission:bulk_import.view');
            Route::post('/preview', [BulkImportController::class, 'preview'])->name('bulk-import.preview')->middleware('permission:bulk_import.run');
            Route::post('/commit', [BulkImportController::class, 'commit'])->name('bulk-import.commit')->middleware('permission:bulk_import.run');
            Route::get('/batch/{batch}', [BulkImportController::class, 'batchRows'])->name('bulk-import.batch')->middleware('permission:bulk_import.view');
        });

        // Chat Routes

        Route::prefix('chat')->middleware('permission:chat.view')->group(function () {
            Route::get('/', [ChatController::class, 'index'])->name('chat.index');
            Route::get('/conversations', [ChatController::class, 'conversations'])->name('chat.conversations');
            Route::get('/unread-count', [ChatController::class, 'unreadCount'])->name('chat.unread');
            Route::get('/users/search', [ChatController::class, 'searchUsers'])->name('chat.users.search');
            Route::get('/{conversation}/messages', [ChatController::class, 'messages'])->name('chat.messages');
            Route::get('/{conversation}/profile', [ChatController::class, 'profile'])->name('chat.profile');
            Route::get('/{conversation}/poll', [ChatController::class, 'poll'])->name('chat.poll');
            Route::post('/{conversation}/messages', [ChatController::class, 'store'])->name('chat.messages.store');

            // Streams attachments/avatars from the 'public' disk directly,
            // instead of relying on the public/storage symlink.
            Route::get('/attachments/{message}', [ChatController::class, 'attachment'])->name('chat.attachment');
            Route::get('/avatar', [ChatController::class, 'avatar'])->name('chat.avatar');

            Route::post('/start-direct', [ChatController::class, 'startDirect'])
                ->name('chat.start.direct')->middleware('permission:chat.create');
            Route::post('/create-group', [ChatController::class, 'createGroup'])
                ->name('chat.create.group')->middleware('permission:chat.create');
        });

        // Reports Routes

        Route::prefix('reports')->group(function () {
            Route::get('/{module}', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
            Route::get('/{module}/export/pdf', [\App\Http\Controllers\ReportController::class, 'exportPdf'])->name('reports.export.pdf');
        });

        // Cascading Location Routes (Region/District/County/Mosque)

        Route::prefix('locations')->group(function () {
            Route::get('/regions', [\App\Http\Controllers\LocationController::class, 'regions'])->name('locations.regions');
            Route::get('/districts', [\App\Http\Controllers\LocationController::class, 'districts'])->name('locations.districts');
            Route::get('/counties', [\App\Http\Controllers\LocationController::class, 'counties'])->name('locations.counties');
            Route::get('/mosques', [\App\Http\Controllers\LocationController::class, 'mosques'])->name('locations.mosques');
        });

        // Certificates Module (Director-only: search, preview, quick-edit, bulk print)

        Route::prefix('certificates')->middleware('permission:certificates.view')->group(function () {
            Route::get('/', [\App\Http\Controllers\CertificateController::class, 'index'])->name('certificates.index');
            Route::get('/bulk-print', [\App\Http\Controllers\CertificateController::class, 'bulkPrint'])->name('certificates.bulk-print');
            Route::get('/{type}/{id}/preview', [\App\Http\Controllers\CertificateController::class, 'preview'])->name('certificates.preview');
            Route::post('/{type}/{id}/update-field', [\App\Http\Controllers\CertificateController::class, 'updateField'])->name('certificates.update-field');
        });

        // Search Routes 
        Route::post('/smart-search', 'smartSearch');

        // Rendered Search Routes 

        Route::get('/nikah/view/{id}', 'viewNikahRecords')->middleware('permission:nikah.view');
        Route::get('/divorce/view/{id}', 'viewDivorceRecords')->middleware('permission:divorce.view');
        Route::get('/inheritance/view/{id}', 'viewInheritanceRecords')->middleware('permission:inheritance.view');
        Route::get('/guardianship/view/{id}', 'viewGuardianshipRecords')->middleware('permission:guardianship.view');
        Route::get('/convert/view/{id}', 'viewConvertRecords')->middleware('permission:convert.view');

    });
});

Route::get('/test1', function () {
    return view('test1');
});


// Consultancy Routes - make sure all these exist
Route::prefix('consultancy')->middleware('permission:consultancy.view')->group(function () {
    Route::get('/', [ConsultancyController::class, 'index'])->name('consultancy.index');
    Route::get('/dashboard', [ConsultancyController::class, 'dashboard'])->name('consultancy.dashboard');
    Route::get('/create', [ConsultancyController::class, 'create'])->name('consultancy.create')->middleware('permission:consultancy.create');
    Route::post('/', [ConsultancyController::class, 'store'])->name('consultancy.store')->middleware('permission:consultancy.create');
    Route::get('/{consultancy}', [ConsultancyController::class, 'show'])->name('consultancy.show');
    Route::get('/{consultancy}/edit', [ConsultancyController::class, 'edit'])->name('consultancy.edit')->middleware('permission:consultancy.edit');
    Route::put('/{consultancy}', [ConsultancyController::class, 'update'])->name('consultancy.update')->middleware('permission:consultancy.edit');
    Route::delete('/{consultancy}', [ConsultancyController::class, 'destroy'])->name('consultancy.destroy')->middleware('permission:consultancy.delete');
    Route::post('/{consultancy}/review', [ConsultancyController::class, 'review'])->name('consultancy.review')->middleware('permission:consultancy.review');
    Route::post('/{consultancy}/sign', [ConsultancyController::class, 'sign'])->name('consultancy.sign')->middleware('permission:consultancy.sign');
    Route::post('/{consultancy}/reject', [ConsultancyController::class, 'reject'])->name('consultancy.reject')->middleware('permission:consultancy.review');
    Route::post('/{consultancy}/status', [ConsultancyController::class, 'updateStatus'])->name('consultancy.status')->middleware('permission:consultancy.review');
    Route::get('/{consultancy}/print', [ConsultancyController::class, 'printCertificate'])->name('consultancy.print');
    Route::get('/{consultancy}/data', [ConsultancyController::class, 'getData'])->name('consultancy.data');
});