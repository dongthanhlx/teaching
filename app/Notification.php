<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'type', 'data', 'class_id', 'created_by'
    ];

    public function find($id)
    {
        return $this->findOrFail($id);
    }

    public function add($input, User $creator)
    {
        return $this->create([
            'type' => $input['type'],
            'data' => $input['data'],
            'class_id' => $input['classId'],
            'created_by' => $creator->id
        ]);
    }

    public function edit($input, $id)
    {
        $notification = $this->find($id);
        $notification->type = $input['type'];
        $notification->data = $input['data'];
        $notification->class_id = $input['classId'];
        $notification->save();

        return $notification;
    }

    public function remove($id)
    {
        $notification = $this->find($id);
        return $notification->delete();
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'students_notifications', 'notification_id', 'student_id');
    }
}
