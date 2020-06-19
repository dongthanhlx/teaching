<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'content', 'public', 'created_by'
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
            'content' => $input['content'],
            'public' => $input['public'],
            'created_by' => $creator->id
        ]);
    }

    public function edit($input, $id)
    {
        $question = $this->find($id);

        $question->content = $input['content'];
        $question->public = $input['public'];

        return $question->save();
    }

    public function remove($id)
    {
        $question = $this->find($id);
        return $question->delete();
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function detail()
    {
        return $this->with('answers');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'questions_tags',
            'question_id',
            'tag_id'
        );
    }

    public function public(bool $status, $id)
    {
        $question = $this->find($id);
        $question->public = $status;
        return $question;
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getAll()
    {
        $questions = $this->all();

        foreach ($questions as $key => $question) {
            $questions[$key] = $question->with(['tags', 'createdBy', 'answers'])->findOrFail($question->id);
        }

        return $questions;
    }

    public function publicStatus()
    {
        $questions = $this->all()->where('public', '=', true);

        foreach ($questions as $question) {
            $question->with('tags');
            $question->with('createdBy');
            $question->with('answers');
        }

        return $questions;
    }
}
