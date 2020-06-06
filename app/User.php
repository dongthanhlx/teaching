<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function role()
    {
        return $this->role;
    }

    public function find($id)
    {
        return $this->findOrFail($id);
    }

    public function add($input)
    {
        return $this->create([
            'user' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'role' => $input['role']
        ]);
    }

    public function editName($name, User $user)
    {
        $user->name = $name;
        $user->save();
    }
}
