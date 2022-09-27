<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'image',
        'state',
        'municipality',
        'address',
        'zip_code',
        'username',
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
    ];

    public function fullAddress(): string
    {
        if ($this->address == null) {
            return '-';
        }
        return $this->address . ', ' . $this->municipality . ', ' . $this->state . ', ' . $this->zip_code;
    }

    public function image(): string
    {
        if ($this->image == null) {
            return asset('img/placeholder.png');
        }


        return '/' . $this->image;
    }

    public function imagePath(): ?string
    {
        if ($this->image != null) {
            $path = explode('/', $this->image);
            return $path[1] . '/' . $path[2];
        } else {
            return null;
        }

    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
