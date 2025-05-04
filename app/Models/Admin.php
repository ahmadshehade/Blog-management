<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
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
     * Get the posts written by the admin.
     */


    public function posts()
    {
        return $this->hasMany(Post::class,'admin_id','id');
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    /**
     * Get the custom claims that will be appended to the JWT payload.
     *
     * @return array<string, mixed>
     */

    public function getJWTCustomClaims()
    {
        return [];
    }


  /**
   * Get all of the comments for the Admin
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */

  public function comments(): HasMany
  {
      return $this->hasMany(Comment::class, 'foreign_key', 'local_key');
  }
}
