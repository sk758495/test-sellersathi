<?php

namespace App\Models;

// Admin model
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Notifications\AdminCustomVerifyEmail;


class Admin extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $guard = 'admin'; // Ensure this is set to 'admin'

    protected $fillable = [
        'name', 'email', 'phone', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new AdminCustomVerifyEmail);
    }

}

