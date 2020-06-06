<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $fillable = [
        'name', 'code', 'teacher_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function teacher()
    {
        return $this->hasOne(User::class, 'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'classes_users', 'class_id', 'user_id');
    }

    protected function find($id)
    {
        return $this->findOrFail($id);
    }

    public function add($input, $creator)
    {
        return $this->create([
            'name' => $input['name'],
            'code' => $input['code'],
            'teacher_id' => $creator->id,
        ]);
    }

    public function edit($input, $id)
    {
        $class = $this->find($id);
        $class->name = $input['name'];
        $class->code = $input['code'];
        return $class->save();
    }

    public function remove($id)
    {
        $class = $this->find($id);
        return $class->delete();
    }
}
