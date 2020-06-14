<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'content', 'question_id', 'is_true', 'created_by'
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
            'question_id' => $input['questionId'],
            'is_true' => $input['isTrue'],
            'created_by' => $creator->id,
        ]);
    }

    public function edit($input, $id)
    {
        $answer = $this->find($id);
        $answer->content = $input['content'];
        $answer->is_true = $input['isTrue'];
        $answer->save();

        return $answer;
    }

    public function remove($id)
    {
        $answer = $this->find($id);
        return $answer->delete();
    }

    public function isTrue()
    {
        return $this->is_true;
    }
}
