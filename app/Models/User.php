<?php

namespace App\Models;

use App\Notifications\Notification;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Route;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    const TABLE_NAME = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'family_name',
        'first_name',
        'gender',
        'email',
        'phone',
        'password',
        'avatar_image_path',
        'remember_token',
        'email_verified_at',
        'last_login_at',
        'allowed_ips',
        'language',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'avatar_image_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
        'allowed_ips' => 'array',
    ];

    protected $appends = ['full_name'];

    public function getAuthIdentifierForBroadcasting()
    {
        return "users_" . $this->id;
    }

    public function sendPasswordResetNotification($token): void
    {
        $url = route('web.password.reset', [
            'token' => $token,
            'email' => $this->getEmailForPasswordReset(),
        ]);
        $this->notify(new Notification(
            via: ['mail'],
            holder: 'web',
            category: 'password',
            action_to_receiver: 'reset_to_user',
            data: [
                'mail' => [
                    'mail_objects' => [
                        'url' => $url,
                        'count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire'),
                    ],
                ],
            ]
        ));
    }

    public function getFullNameAttribute(): string
    {
        return $this->family_name . ' ' . $this->first_name;
    }

    public function getActivityLogNameAttribute(): string
    {
        if ($this->Trashed()) {
            return __('label.deleted');
        }

        $name = $this->full_name;
        if (Route::is('admin.*')) {
            return "<a href='" . route('admin.users.edit', $this->id) . "'>" . $name . "</a>";
        }
        return $name;
    }

    public function notifications()
    {
        return $this->hasMany(UserNotification::class, 'user_id', 'id')
            ->with(['notificationObjects'])
            ->orderBy('created_at', 'desc');
    }
    
    public function getLatestSimplifiedNotifications($limit = 10)
    {
        $notifications = $this->notifications()->limit($limit)->get();

        $notifications->each(function ($notification) {
            $notification->loadRelatedModels();
        });

        return $notifications;
    }

    public function unreadNotifications(): HasMany
    {
        return $this->notifications()->where('read_yn', 'n');
    }

    public function getIsReadAttribute()
    {
        return $this->read_yn == 'y';
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format(config('const.date_format'));
    }

    public function routeNotificationForWeb($notification)
    {
        return $this;
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'user_admins');
    }
}
