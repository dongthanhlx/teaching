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

    public function add($request)
    {
        return $this->create([
            'name' => $request->name,
            'code' => $request->code,
            'teacher_id' => $request->user()->id,
        ]);
    }

    public function edit($request, $id)
    {
        $class = $this->find($id);
        $class->name = $request->name;
        $class->code = $request->code;
        return $class->save();
    }

    public function remove($id)
    {
        $class = $this->find($id);
        return $class->delete();
    }
}
