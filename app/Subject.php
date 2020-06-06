<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name', 'created_by'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected function find($id)
    {
        return $this->findOrFail($id);
    }

    public function add($input, $creator)
    {
        return $this->create([
            'name' => $input['name'],
            'created_by' => $creator->id
        ]);
    }

    public function edit($input, $id)
    {
        $subject = $this->find($id);
        $subject->name = $input['name'];
        return $subject->save();
    }

    public function remove($id)
    {
        $subject =  $this->find($id);
        return $subject->delete();
    }
}
