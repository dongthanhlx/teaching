<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $subject;

    /**
     * SubjectController constructor.
     * @param $subject
     */
    public function __construct(Subject $subject)
    {
        $this->subject = $subject;
    }

    public function store(SubjectRequest $request)
    {
        $request->validated();
        $this->subject = $this->subject->add($request->all(), $request->user());
        return response()->json($this->subject, 200);
    }

    public function update(SubjectRequest $request, $id)
    {
        $request->validated();
        $this->subject = $this->subject->edit($request, $id);
        return response()->json($this->subject, 200);
    }

    public function delete($id)
    {
        $this->subject = $this->subject->remove($id);
        return response()->json($this->subject, 200);
    }
}
