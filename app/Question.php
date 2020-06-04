<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'content', 'class', 'subject_id', 'tags', 'created_by'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function find($id)
    {
        return $this->findOrFail($id);
    }

    public function add($request)
    {
        return $this->create([
            'content' => $request->content,
            'class' => $request->class,
            'subject_id' => $request->subjectId,
            'tags' => $request->tags,
            'created_by' => $request->user()->id
        ]);
    }

    public function edit($id, $input)
    {
        $question = $this->find($id);

        $question->content =  $input['content'];
        $question->class = $input['class'];
        $question->subject_id = $input['subjectId'];
        $question->tags = $input['tags'];

        return $question->save();
    }

    public function remove($id)
    {
        $question = $this->find($id);
        return $question->delete();
    }
}
