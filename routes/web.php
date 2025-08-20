<?php

use App\Http\Controllers\Web\ChatController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\NotificationController;
use App\Http\Controllers\Web\SitemapController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::domain(config('app.web_domain'))
    ->prefix(config('app.web_url'))
    ->as('web.')->namespace('Web')
    ->middleware(['web.locale'])
    ->group(function () {
        Auth::routes([
            'register' => true,
            'reset' => true,
            'verify' => false,
            'logout' => true,
        ]);

        Route::middleware('auth:user')->group(function () {
            // Notifications
            Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
            Route::post('notifications/mark_all_as_read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark_all_as_read');
            Route::post('notifications/{notification}/mark_as_read', [NotificationController::class, 'markAsRead'])->name('notifications.mark_as_read');

            // Chat
            Route::get('chats', [ChatController::class, 'index'])->name('chats.index');
            Route::get('chats/{chat}', [ChatController::class, 'show'])->name('chats.show');
            Route::get('chats/{chat}/messages', [ChatController::class, 'messages'])->name('chats.messages');
            Route::post('chats/{chat}/messages', [ChatController::class, 'storeMessage'])->name('chats.messages.store');
            Route::post('chats/{chat}/mark_as_read', [ChatController::class, 'markAsRead'])->name('chats.mark_as_read');
            Route::post('chats/support', [ChatController::class, 'support'])->name('chats.support');
            Route::post('/{chat}/upload_file', [ChatController::class, 'uploadFile'])->name('chats.upload_file');
            Route::get('chats/messages/{message}/file', [ChatController::class, 'showFile'])->name('chats.show_file');
        });

        // User avatar
        Route::get('/users/{user}/avatar', [UserController::class, 'showAvatar'])->name('users.show_avatar');

        Route::get('/', [HomeController::class, 'home'])->name('home');

        // Contact Us
        Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::post('contacts', [ContactController::class, 'store'])->name('contacts.store');

        // sitemap
        Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
    });
