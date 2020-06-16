<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name', 'created_by'
    ];

    public function find($id)
    {
        return $this->findOrFail($id);
    }

    public function add($input, User $creator)
    {
        return $this->create([
            'name' => $input['name'],
            'created_by' => $creator->id
        ]);
    }

    public function edit($input, $id)
    {
        $tag = $this->find($id);
        $tag->name = $input['name'];
        $tag->save();

        return $tag;
    }

    public function remove($id)
    {
        $tag = $this->find($id);
        return $tag->delete();
    }

    public function questions()
    {
        return $this->belongsToMany(
            Question::class,
            'questions_tags',
            'tag_id',
            'question_id'
        );
    }

    public function testSubjects()
    {
        return $this->belongsToMany(
            TestSubject::class,
            'test_subjects_tags',
            'tag_id',
            'test_subject_id'
        );
    }
}
