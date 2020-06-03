<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $subject;

    public function __construct()
    {
        $this->subject = new Subject();
    }

    public function store(SubjectRequest $request)
    {
        $validated = $request->validated();
        if (! $validated) return null;

        $result = $this->subject->add($request);
        return response()->json($result, 200);
    }

    public function update(SubjectRequest $request, $id)
    {
        $validated = $request->validated();

        if (! $validated) return null;

        $result = $this->subject->edit($request, $id);
        return response()->json($result, 200);
    }

    public function delete($id)
    {
        $result = $this->subject->remove($id);

        return response()->json($result, 200);
    }
}
