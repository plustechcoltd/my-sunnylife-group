<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DemoController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::domain(config('app.admin_domain'))
    ->prefix(config('app.admin_url'))
    ->namespace('Admin')
    ->middleware(['admin.locale'])
    ->group(function () {
        Route::as('admin.')->group(function () {
            Auth::routes([
                'register' => false,
                'reset' => true,
                'verify' => false,
                'logout' => true,
            ]);

            Route::middleware('auth:admin')->group(function () {
                Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

                // users
                Route::group(['middleware' => 'can:admin:users'], function () {
                    Route::resource('users', UserController::class)->except(['show']);
                    Route::put('/users/{user}/update_password', [UserController::class, 'updatePassword'])->name('users.update_password');
                    Route::get('/users/{user}/edit_password', [UserController::class, 'editPassword'])->name('users.edit_password');
                    Route::get(
                        '/users/{user}/edit_manager',
                        [UserController::class, 'editManager']
                    )->name('users.edit_manager');
                    Route::put(
                        '/users/{user}/update_admin_manager',
                        [UserController::class, 'updateAdminManager']
                    )->name('users.update_admin_manager');
                    Route::get('/users/import', [UserController::class, 'importCsv'])->name('users.import');
                    Route::post('users/upload_csv', [UserController::class, 'uploadCsv'])->name('users.upload_csv');
                    Route::post('/users/export_csv', [UserController::class, 'exportCsv'])->name('users.export_csv');
                });
                Route::get('/users/{user}/avatar', [UserController::class, 'showAvatar'])->name('users.show_avatar');

                // admins
                Route::group(['middleware' => 'can:admin:admins'], function () {
                    Route::resource('admins', AdminController::class)->except(['show']);
                    Route::put('/admins/{admin}/update_permissions', [AdminController::class, 'updatePermissions'])->name('admins.update_permissions');
                    Route::put('/admins/{admin}/update_password', [AdminController::class, 'updatePassword'])->name('admins.update_password');
                    Route::get('/admins/{admin}/edit_permissions', [AdminController::class, 'editPermissions'])->name('admins.edit_permissions');
                    Route::get('/admins/{admin}/edit_password', [AdminController::class, 'editPassword'])->name('admins.edit_password');
                });
                

                // admin profile
                Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
                Route::get('profile/edit_permissions', [ProfileController::class, 'editPermissions'])->name('profile.edit_permissions');
                Route::get('profile/edit_password', [ProfileController::class, 'editPassword'])->name('profile.edit_password');
                Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
                Route::put('/profile/permissions', [ProfileController::class, 'updatePermissions'])->name('profile.update_permissions');
                Route::put('/profile/update_password', [ProfileController::class, 'updatePassword'])->name('profile.update_password');
                Route::get('/profile/avatar', [ProfileController::class, 'showAvatar'])->name('profile.show_avatar');

                // activity_logs
                Route::group(['middleware' => 'can:admin:activity_logs'], function () {
                    Route::get('/activity_logs', [ActivityLogController::class, 'index'])->name('activity_logs.index');
                });

                // notifications
                Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
                Route::post('notifications/mark_all_as_read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark_all_as_read');
                Route::post('notifications/{notification}/mark_as_read', [NotificationController::class, 'markAsRead'])->name('notifications.mark_as_read');

                // chats
                Route::get('chats', [ChatController::class, 'index'])->name('chats.index');
                Route::get('chats/{chat}', [ChatController::class, 'show'])->name('chats.show');
                Route::get('chats/{chat}/messages', [ChatController::class, 'messages'])->name('chats.messages');
                Route::post('chats/{chat}/messages', [ChatController::class, 'storeMessage'])->name('chats.messages.store');
                Route::post('chats/{chat}/mark_as_read', [ChatController::class, 'markAsRead'])->name('chats.mark_as_read');
                Route::post('chats/{chat}/join', [ChatController::class, 'joinChat'])->name('chats.join');
                Route::post('chats/{chat}/leave', [ChatController::class, 'leaveChat'])->name('chats.leave');
                Route::post('/{chat}/upload_file', [ChatController::class, 'uploadFile'])->name('chats.upload_file');
                Route::get('chats/messages/{message}/file', [ChatController::class, 'showFile'])->name('chats.show_file');

                // Settings
                Route::group(['middleware' => 'can:admin:settings'], function () {
                    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
                    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
                });

                Route::group(['middleware' => 'can:admin:languages'], function () {
                    Route::get('/languages', [LanguageController::class, 'index'])->name('languages.index');
                    Route::get('/languages/create', [LanguageController::class, 'create'])->name('languages.create');
                    Route::post('/languages/create', [LanguageController::class, 'store'])->name('languages.store');
                    Route::get('/languages/{language}/edit', [LanguageController::class, 'edit'])->name('languages.edit');
                    Route::put('/languages/{language}/update', [LanguageController::class, 'update'])->name('languages.update');
                    Route::delete('/languages/{language}', [LanguageController::class, 'destroy'])->name('languages.destroy');
                });

                // Limitless Demo
                Route::get('{any}', [DemoController::class, 'index'])->name('demo.index');
            });

            Route::get('/admins/{admin}/avatar', [AdminController::class, 'showAvatar'])->name('admins.show_avatar');
        });
    });
