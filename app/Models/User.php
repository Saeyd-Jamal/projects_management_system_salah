<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'email',
        'phone',
        'avatar',
        'super_admin',
        'last_activity',
        'rememberMe',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationship
    public function roles() :HasMany
    {
        return $this->hasMany(RoleUser::class,'user_id','id');
    }

    // Accessors
    public function getAvatarUrlAttribute()
    {
        if(!$this->avatar){
            return asset('img/user.jpg');
        }
        if(Str::startsWith($this->avatar,['http://','https://'])){
            return $this->avatar;
        }
        return asset('storage/'. $this->avatar);
    }
}
