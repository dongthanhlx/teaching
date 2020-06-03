<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id', 'birthday', 'phone', 'school', 'address', 'avatar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function find($id)
    {
        return $this->findOrFail($id);
    }

    public function add($input)
    {
        return $this->create([
            'user_id' => $input['userId'],
            'birthday' => $input['birthday'],
            'phone' => $input['phone'],
            'school' => $input['school'],
            'address' => $input['address'],
            'avatar' => $input['avatar']
        ]);
    }

    public function edit($id, $input)
    {
        $userDetail = $this->find($id);
        $userDetail->birthday = $input['birthday'];
        $userDetail->phone = $input['phone'];
        $userDetail->school = $input['school'];
        $userDetail->address = $input['address'];
        $userDetail->avatar = $input['avatar'];

        return $userDetail->save();
    }
}
