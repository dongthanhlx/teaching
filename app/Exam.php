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
        'subject_id',
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
            'subject_id' => $input['subjectId'],
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
        $exam->subject_id = $input['subjectId'];
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

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exams_questions', 'exam_id', 'question_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function addQuestion(Question $question)
    {
        return $this->questions()->save($question);
    }
}
