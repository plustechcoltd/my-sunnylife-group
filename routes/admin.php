<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Ajax\CityController;
use App\Http\Controllers\Admin\Ajax\TrainLineController;
use App\Http\Controllers\Admin\Ajax\TrainStationController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\LocationController;
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

                // locations
                Route::group(['middleware' => 'can:admin:institutions'], function () {
                    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
                    Route::get('/locations/create', [LocationController::class, 'create'])->name('locations.create');
                    Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
                    Route::get('/locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
                    Route::put('/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
                    Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
                    Route::get('/locations/export_csv', [LocationController::class, 'exportCsv'])->name('locations.export_csv');
                    Route::get('locations/import_csv', [LocationController::class, 'importCsv'])->name('locations.import_csv');
                    Route::post('/locations/upload_csv', [LocationController::class, 'uploadCsv'])->name('locations.upload_csv');
                });

                // location_groups
                Route::group(['middleware' => 'can:admin:location_groups'], function () {
                    Route::get('/location_groups', [LocationGroupController::class, 'index'])->name('location_groups.index');
                    Route::get('/location_groups/create', [LocationGroupController::class, 'create'])->name('location_groups.create');
                    Route::post('/location_groups', [LocationGroupController::class, 'store'])->name('location_groups.store');
                    Route::get('/location_groups/{location_group}/edit', [LocationGroupController::class, 'edit'])->name('location_groups.edit');
                    Route::put('/location_groups/{location_group}', [LocationGroupController::class, 'update'])->name('location_groups.update');
                    Route::delete('/location_groups/{location_group}', [LocationGroupController::class, 'destroy'])->name('location_groups.destroy');
                });

                // cities
                Route::group(['middleware' => 'can:admin:cities'], function () {
                    Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
                    Route::get('/cities/{city}/edit', [CityController::class, 'edit'])->name('cities.edit');
                    Route::put('/cities/{city}', [CityController::class, 'update'])->name('cities.update');
                });

                // city_groups
                Route::group(['middleware' => 'can:admin:city_groups'], function () {
                    Route::get('/city_groups', [CityGroupController::class, 'index'])->name('city_groups.index');
                    Route::get('/city_groups/create', [CityGroupController::class, 'create'])->name('city_groups.create');
                    Route::post('/city_groups', [CityGroupController::class, 'store'])->name('city_groups.store');
                    Route::get('/city_groups/{city_group}/edit', [CityGroupController::class, 'edit'])->name('city_groups.edit');
                    Route::put('/city_groups/{city_group}', [CityGroupController::class, 'update'])->name('city_groups.update');
                    Route::delete('/city_groups/{city_group}', [CityGroupController::class, 'destroy'])->name('city_groups.destroy');
                });

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

            });

            Route::get('/admins/{admin}/avatar', [AdminController::class, 'showAvatar'])->name('admins.show_avatar');
        });

        // ajax
        Route::get('/ajax/cities', [CityController::class, 'index'])->name('ajax.cities.index');
        Route::get('/ajax/train_lines', [TrainLineController::class, 'index'])->name('ajax.train_lines.index');
        Route::get('/ajax/train_stations', [TrainStationController::class, 'index'])->name('ajax.train_stations.index');
    });
