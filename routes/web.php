<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LockController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Home Page
Route::view('/', 'App')->name('home');
// Error Page
Route::view('/404', 'Backend.Pages.Errors.404-Page');

// Admin Panel View Routes
// Login Page
Route::get('/secure-control/login/', [UserController::class, 'loginPageView'])->name('backend.login');
Route::group(['prefix' => '/secure-control', 'middleware' => 'jwt.auth'], function () {
    // Error Pages
    Route::view('/403', 'Backend.Pages.Errors.403-Page')->name('backend.403');

    // auth routes
    Route::get('/logout', [UserController::class, 'UserLogout'])->name('backend.logout');

    // dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('backend.dashboard')
        ->middleware('role_or_permission:dashboard');;

    // profile
    Route::get('/profile', [DashboardController::class, 'profilePageView'])->name('backend.profile');

    //users
    Route::get('/users', [UserController::class, 'UserPageView'])->name('backend.users')
        ->middleware('role_or_permission:user-list|user-create|user-update|user-delete');


    // roles
    Route::get('/roles', [RoleController::class, 'RolePageView'])->name('backend.roles')
    ->middleware('role_or_permission:role-list|role-update|role-edit|role-delete');

    // permissions
    Route::get('/permissions', [RoleController::class, 'PermissionPageView'])->name('backend.permissions')
    ->middleware('role_or_permission:permission-list|permission-create|permission-update|permission-delete');

    // passkey
    Route::get('/passkey', [LockController::class, 'PasskeyPage'])->name('backend.passkey')
        ->middleware('role_or_permission:passkey-lock');

    // logs
    Route::get('/logs', [LockController::class, 'LogPage'])->name('backend.logs')
        ->middleware('role_or_permission:user-logs');

   // settings
    Route::get('/settings', [SettingController::class, 'SettingPage'])->name('backend.settings')
        ->middleware('role_or_permission:settings');


});
// Secure Data Controls API Routes
Route::group(['prefix' => 'SecureDataControls'], function () {
    // auth routes
    Route::post('/login', [UserController::class, 'UserLogin'])->name('SecureDataControls.login');

    // users
    Route::get('/get-users', [UserController::class, 'getUsers']);
    Route::post('/create-users', [UserController::class, 'createUser']);
    Route::post('/user-by-id', [UserController::class, 'getUserById']);
    Route::post('/get-user-roles-by-id', [UserController::class, 'getUserRolesById']);
    Route::post('/update-users', [UserController::class, 'updateUser']);
    Route::post('/user-delete-by-id/', [UserController::class, 'UserDeleteById']);
    Route::get('/user-profile', [UserController::class, 'UserProfile']);
    Route::post('/update-profile', [UserController::class, 'UpdateUserProfile']);
    Route::post('/update-password', [UserController::class, 'ChangePassword']);
    Route::post('/update-passkey', [UserController::class, 'ChangePasskey']);

    // permissions
    Route::post('/create-permissions', [RoleController::class, 'createPermissions']);
    Route::get('/get-permissions', [RoleController::class, 'getPermissions']);
    Route::post('/permission-by-id', [RoleController::class, 'getPermissionById']);
    Route::post('/permission-update-by-id', [RoleController::class, 'PermissionUpdateById']);
    Route::post('/permission-delete-by-id/', [RoleController::class, 'PermissionDeleteById']);

    // roles
    Route::post('/create-roles', [RoleController::class, 'createRoles']);
    Route::get('/get-roles', [RoleController::class, 'getRoles']);
    Route::post('/role-by-id', [RoleController::class, 'getRoleById']);
    Route::post('/get-role-has-permissions-by-id', [RoleController::class, 'getRoleHasPermissionsById']);
    Route::post('/update-roles', [RoleController::class, 'updateRoles']);
    Route::post('/role-delete-by-id/', [RoleController::class, 'RoleDeleteById']);

    // Settings
    Route::get('/settings', [SettingController::class, 'GetSettings']);
    Route::post('/update-setting', [SettingController::class, 'UpdateSettings']);


    // passkey
    Route::post('/passkey/', [UserController::class, 'Passkey']);
    Route::post('/get-user-logs/', [UserController::class, 'UnlockLogs']);

});
