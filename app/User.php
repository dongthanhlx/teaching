<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
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

    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function role()
    {
        return $this->role;
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'classes_students', 'class_id', 'user_id');
    }

    protected function notifications()
    {
        return $this->belongsToMany(Notification::class,'students_notifications', 'student_id', 'notification_id');
    }

    public function readNotifications(ClassModel $class)
    {
        return $this->notifications()->where('class_id', '=', $class->id)->wherePivotNotNull('read_at');
    }

    public function unreadNotifications(ClassModel $class)
    {
        return $this->notifications()->where('class_id', '=', $class->id)->wherePivotNull('read_at');
    }
}
