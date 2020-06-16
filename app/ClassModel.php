<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'name', 'description', 'code', 'teacher_id'
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
            'name' => $input['name'],
            'description' => $input['description'],
            'code' => $input['code'],
            'teacher_id' => $creator->id,
        ]);
    }

    public function edit($input, $id)
    {
        $class = $this->find($id);
        $class->name = $input['name'];
        $class->description = $input['description'];
        $class->code = $input['code'];
        return $class->save();
    }

    public function remove($id)
    {
        $class = $this->find($id);
        return $class->delete();
    }

    public function teacher()
    {
        return $this->belongsTo(User::class)->with('detail');
    }

    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'classes_students',
            'class_id',
            'user_id'
        )->with('detail');
    }

    public function hasStudent(User $user)
    {
        return $this->students()->where('users.id', '=', $user->id);
    }

    public function exams()
    {
        return $this->belongsToMany(
            Exam::class,
            'exams_classes',
            'class_id',
            'exam_id'
        );
    }

    public function addExam(Exam $exam)
    {
        return $this->exams()->attach($exam->id);
    }

    public function addStudent(User $user)
    {
        return $this->students()->attach($user->id);
    }

    public function removeStudent(User $user)
    {
        return $this->students()->detach($user->id);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'class_id');
    }
}
