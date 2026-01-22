<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MasterController;


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
Route::controller(AdminController::class)->group(function () {

    Route::group(['middleware' => ['AdminAuth']], function () {
        Route::group(['prefix' => '/users'], function () {

            Route::get('add-admin', 'addAdmin')->name('add.admin');
            Route::get('all-admins', 'addAdmins')->name('all.admins');
            Route::get('dashboard', 'adminDashboard')->name('user.dashboard');
            Route::get('login', 'userLogin')->name('user.login');
            Route::get('profile', 'userProfile')->name('user.profile');
            Route::get('/forgot-password', 'forgotPassword')->name('forgot-password');

            Route::delete('/admin/{id}', 'destroy')->name('admin.destroy');

            Route::put('/admin/{admin}', 'updateAdmin')->name('admin.update');
            Route::post('/store-admin', 'storeAdmin')->name('admin.store');
            Route::post('/admin/{id}/change-status', 'changeStatus')->name('admin.changeStatus');
            Route::post('/admin/change-password', 'changePassword')->name('admin.change.password');
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
        Route::get('/guardianship-application', 'guardianshipApplication')->name('guardianship.application');
        Route::get('/convert-application', 'convertApplication')->name('convert.application');

        // Nikah Routes 

        Route::get('nikah-dashboard', 'nikahDashboard')->name('nikah.dashboard');
        Route::get('/nikah', 'nikahRegistration')->name('landing.nikah');
        Route::get('/nikah/{id}/edit', 'editNikahApplication');
        Route::get('/nikah-applications', 'nikahApplications')->name('nikkah.applications');
        Route::get('/nikah/applications/{id}', 'shownikahApplicationInformation')
            ->name('nikah.show');

        Route::get('/nikah-status-applications/{statusId}', 'nikahStatusApplications')
            ->name('nikah.status.applications');


        Route::delete('/nikah/{id}', 'deleteNikahApplication');

        Route::post('/nikah/{id}/update', 'updateNikahApplication');
        Route::post('/applications/{id}/update-status', 'updateNikkahApplicationStatus');
        Route::post('/save-submitted-nikkah-application', 'saveNikahApplication')->name('nikkah.save');


        // Divorce Routes 

        Route::get('divorce-dashboard', 'divorceDashboard')->name('divorce.dashboard');
        Route::get('/divorce-application', 'divorceApplication')->name('divorce.application');
        Route::get('/divorce-status-applications/{statusId}', 'divorceStatusApplications')
            ->name('divorce.status.applications');

        Route::get('/divorce/{id}/edit', 'editDivorceApplication')->name('divorce.edit.applications');
        Route::get('/divorce/{id}/view', 'viewDivorceApplication')->name('divorce.view.applications');
        Route::get('/divorce/{id}/delete', 'deleteDivorceApplication')->name('divorce.delete.applications');


        Route::get('/nikah/applications/{id}', 'showdivorceApplicationInformation')
            ->name('nikah.show');

        Route::post('/save-submitted-divorce-application', 'saveDivorceApplication')->name('save.divorce.application');
        Route::post('/save-updated-divorce-application-data', 'saveUpdatedDivorceApplication')->name('save.updated.divorce.application.data');

        // Inheritance Routes 

        Route::get('/inheritance-application', 'inheritanceApplication')->name('inheritance.application');
        Route::get('inheritance-dashboard', 'inheritanceDashboard')->name('inheritance.dashboard');
        Route::get('/inheritance-status-applications/{statusId}', 'inheritanceStatusApplications')
            ->name('inheritance.status.applications');

        Route::post('/save-inheritance-application', 'saveInheritanceApplication')->name('save.inheritance.application');


        // Guardianship Routes 

        Route::get('guardianship-dashboard', 'guardianshipDashboard')->name('guardianship.dashboard');

        Route::get('/guardianship-status-applications/{statusId}', 'guardianshipStatusApplications')
            ->name('guardianship.status.applications');

        Route::post('/save-guardianship-application', 'saveguardianshipApplication')->name('save.guardianship.application');

        // Converts Routes 

        Route::get('/convert-status-applications/{statusId}', 'convertStatusApplications')
            ->name('convert.status.applications');
        Route::get('convert-dashboard', 'convertDashboard')->name('convert.dashboard');
        Route::post('/save-convert-application', 'saveconvertApplication')->name('save.convert.application');

        // Users Routes 

        Route::get('users-dashboard', 'usersDashboard')->name('users.dashboard');
        Route::get('add-users', 'addUsers')->name('add.users');
        Route::get('manage-users', 'manageUsers')->name('manage.users');
        Route::post('/save-user-application', 'saveNewUser')->name('save.new.user');

        // Search Routes 
        Route::post('/smart-search', 'smartSearch');

        // Rendered Search Routes 

        Route::get('/nikah/view/{id}', 'viewNikahRecords');
        Route::get('/divorce/view/{id}', 'view');
        Route::get('/inheritance/view/{id}', 'view');
        Route::get('/guardianship/view/{id}', 'view');
        Route::get('/convert/view/{id}', 'view');

    });
});

Route::get('/test1', function () {
    return view('test1');
});

