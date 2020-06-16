<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'header',
        'description',
        'class',
        'time',
        'note',
        'rating',
        'type',
        'start_time',
        'created_by'
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
            'header' => $input['header'],
            'description' => $input['description'],
            'class' => $input['class'],
            'time' => $input['time'],
            'note' => $input['note'],
            'rating' => $input['rating'],
            'type' => $input['type'],
            'start_time' => $input['startTime'],
            'created_by' => $creator->id,
        ]);
    }

    public function edit($input, $id)
    {
        $exam = $this->find($id);

        $exam->header = $input['header'];
        $exam->description = $input['description'];
        $exam->class = $input['class'];
        $exam->time = $input['time'];
        $exam->note = $input['note'];
        $exam->rating = $input['rating'];
        $exam->type = $input['type'];
        $exam->start_time = $input['startTime'];

        return $exam->save();
    }

    public function remove($id)
    {
        $exam = $this->find($id);
        return $exam->delete();
    }

    public function testSubjects()
    {
        return $this->belongsToMany(
            TestSubject::class,
            'exams_test_subjects',
            'exam_id',
            'test_subject_id'
        );
    }

    public function addTestSubject(TestSubject $testSubject)
    {
        return $this->testSubjects()->attach($testSubject->id);
    }

    public function removeTestSubject(TestSubject $testSubject)
    {
        return $this->testSubjects()->detach($testSubject->id);
    }

    public function classes()
    {
        return $this->belongsToMany(
            ClassModel::class,
            'exams_classes',
            'exam_id',
            'class_id'
        );
    }
}
