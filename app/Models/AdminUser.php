<?php

namespace App\Models;

use App\Notifications\AdminUserResetPasswordNotification;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable as Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class AdminUser extends Authenticatable implements Auditable, HasMedia
{
    use Notifiable;
    use HasRoles;
    use InteractsWithMedia;
    use CanResetPassword;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $auditInclude = [
        'email', 'password', 'roles'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatars')
             ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif'])
             ->singleFile();
    }

    /**
     * Register media conversions
     *
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('avatar')
             ->width(200)
             ->height(200)
             ->performOnCollections('avatars');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminUserResetPasswordNotification($token));
    }
}
