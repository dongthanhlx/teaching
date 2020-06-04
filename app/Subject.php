<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected function find($id)
    {
        return $this->findOrFail($id);
    }

    public function add($request)
    {
        return $this->create([
            'name' => $request->name
        ]);
    }

    public function edit($request, $id)
    {
        $subject = $this->find($id);
        $subject->name = $request->name;
        return $subject->save();
    }

    public function remove($id)
    {
        $subject =  $this->find($id);
        return $subject->delete();
    }
}
