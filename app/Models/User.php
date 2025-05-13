<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     properties={
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
 *         @OA\Property(property="role", type="string", example="admin"),
 *         @OA\Property(property="email_verified_at", type="string", format="date-time", example="2023-01-01T12:00:00Z"),
 *         @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T12:00:00Z"),
 *         @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-02T12:00:00Z")
 *     }
 * )
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    /**
     * Get the identifier that will be stored in the JWT token.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key-value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
