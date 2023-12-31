<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Traits\CheckRoles;
use App\Notifications\SendEmailVerification;
use App\Notifications\SendResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, CheckRoles;

    const ADMIN_APP = 1;
    const OPERATOR = 2;
    const KORWIL = 3;
    const MEMBER_APP = 4;
    const MEMBER = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sendPasswordResetNotification($token)
    {
        $url = url("/auth/new-password?token=$token&email=$this->email");

        $this->notify(new SendResetPassword($url));
    }

    public function sendActivationUserNotification($token)
    {
        $url = url("/auth/new-password?token=$token&email=$this->email");

        $this->notify(new SendEmailVerification($url));
    }

    public function membership(): HasOne
    {
        return $this->hasOne(Membership::class, 'user_id', 'id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'user_id', 'id');
    }

    public function korwilAssign(): HasOne
    {
        return $this->hasOne(KorwilAssign::class, 'user_id', 'id');
    }
}
