<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestSubject extends Model
{
    protected $table = 'test_subjects';

    protected $fillable = [
        'header', 'type', 'status', 'path', 'created_by'
    ];

    public function find($id)
    {
        return $this->findOrFail($id);
    }

    public function add($input, User $creator)
    {
        return $this->create([
            'header' => $input['header'],
            'type' => $input['type'],
            'status' => $input['status'],
            'path' => $input['path'],
            'created_by' => $creator->id
        ]);
    }

    public function edit($input, $id)
    {
        $testSubject = $this->find($id);
        $testSubject->header = $input['header'];
        $testSubject->type = $input['type'];
        $testSubject->status = $input['status'];
        $testSubject->path = $input['path'];

        return $testSubject->save();
    }

    public function remove($id)
    {
        $testSubject = $this->find($id);
        return $testSubject->delete();
    }

    public function questions()
    {
        return $this->belongsToMany(
            Question::class,
            'test_subjects_questions',
            'test_subject_id',
            'question_id'
        );
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'test_subjects_tags',
            'test_subject_id',
            'tag_id'
        );
    }

    public function exams()
    {
        return $this->belongsToMany(
            Exam::class,
            'exams_test_subjects',
            'test_subject_id',
            'exam_id'
        );
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function publicStatus()
    {
        $testSubjects = $this->all()->where('status', '=', 3);

        foreach ($testSubjects as $testSubject) {
            $testSubject->with('createdBy');
            $testSubject->with('tags');
            $testSubject->questions_length = $testSubject->questions()->count();
        }

        return $testSubjects;
    }
}
