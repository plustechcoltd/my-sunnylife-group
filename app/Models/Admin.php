<?php

namespace App\Models;

use App\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Route;

class Admin extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    const TABLE_NAME = 'admins';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'avatar_image_path',
        'notificationObjects',
    ];

    /**
     * The attributes that should be cast to native types.
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
        return "admins_" . $this->id;
    }

    public function sendPasswordResetNotification($token): void
    {
        $url = route('admin.password.reset', [
            'token' => $token,
            'email' => $this->getEmailForPasswordReset(),
        ]);
        $this->notify(new Notification(
            via: ['mail'],
            holder: 'admin',
            category: 'password',
            action_to_receiver: 'reset_to_admin',
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

    public function adminPermissionAdmins(): HasMany
    {
        return $this->hasMany(AdminPermissionAdmin::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(AdminPermission::class, 'admin_permission_admin');
    }

    public function getPermissionNames(): array
    {
        return $this->permissions()->pluck('name')->toArray();
    }

    public function hasPermission($name): bool
    {
        $adminPermission = AdminPermission::query()->where('name', $name)->first();
        if (!$adminPermission) {
            return false;
        }

        return AdminPermissionAdmin::query()
            ->where('admin_id', $this->id)
            ->where('admin_permission_id', $adminPermission->id)
            ->exists();
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
            return "<a href='" . route('admin.admins.edit', $this->id) . "'>" . $name . "</a>";
        }
        return $name;
    }

    public function notifications()
    {
        return $this->hasMany(AdminNotification::class, 'admin_id', 'id')
            ->select('id', 'admin_id', 'category_type', 'type', 'read_yn', 'created_at')
            ->with(['notificationObjects'])
            ->orderBy('created_at', 'desc');
    }
    
    public function getLatestSimplifiedNotifications($limit = 10)
    {
        $notifications = $this->notifications()->limit($limit)->get();

        $notifications->each(function ($notification) {
            $notification->loadRelatedModels();
        });

        return $notifications->map(function ($notification) {
            $simplifiedObjects = $notification->simplifyNotificationObjects();
            
            $result = $notification->toArray();
            $result['notification_objects'] = $simplifiedObjects;
            return $result;
        });
    }

    public function unreadNotifications(): HasMany
    {
        return $this->notifications()->where('read_yn', 'n');
    }

    public function getIsReadAttribute()
    {
        return $this->read_yn == 'y';
    }

    public function isFemale(): bool
    {
        return $this->gender == config('const.gender_type_values.female');
    }

    public function isMale(): bool
    {
        return $this->gender == config('const.gender_type_values.male');
    }

    public function routeNotificationForWeb($notification)
    {
        return $this;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_admins');
    }
}
