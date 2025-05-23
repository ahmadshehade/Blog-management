<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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


    /**
     * Get the posts for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function posts()
    {
        return $this->hasMany(Post::class,'user_id','id');
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * @return mixed
     */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    /**
     * Get the custom claims for the JWT.
     *
     * @return array<string, mixed>
     */

    public function getJWTCustomClaims()
    {
        return [];
    }
}
