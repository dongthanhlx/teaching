<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id', 'birthday', 'phone', 'school', 'address', 'avatar',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];


    public function find($id)
    {
        return $this->findOrFail($id);
    }

    public function add($input, $creator)
    {
        return $this->create([
            'user_id' => $creator->id,
            'birthday' => $input['birthday'],
            'phone' => $input['phone'],
            'school' => $input['school'],
            'address' => $input['address'],
            'avatar' => $input['avatar']
        ]);
    }

    public function edit($input, $editor)
    {
        $userDetail = $this->find($editor->id);
        (new User())->editName($input['name'], $editor);
        $userDetail->birthday = $input['birthday'];
        $userDetail->phone = $input['phone'];
        $userDetail->school = $input['school'];
        $userDetail->address = $input['address'];
        $userDetail->avatar = $input['avatar'];

        return $userDetail->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
