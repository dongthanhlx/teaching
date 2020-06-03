<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'content', 'question_id', 'is_true', 'created_by'
    ];

    public function isTrue()
    {
        return $this->is_true;
    }

    public function find($id)
    {
        return $this->findOrFail($id);
    }

    public function add($request)
    {
        return $this->create([
            'content' => $request->content,
            'question_id' => $request->questionId,
            'is_true' => $request->isTrue,
            'created_by' => $request->user()->id,
        ]);
    }

    public function edit($request, $id)
    {
        $answer = $this->find($id);
        $answer->content = $request->content;
        $answer->is_true = $request->isTrue;
        $answer->save();

        return $answer;
    }

    public function remove($id)
    {
        $answer = $this->find($id);
        return $answer->delete();
    }
}
