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

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exams_questions', 'exam_id', 'question_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
