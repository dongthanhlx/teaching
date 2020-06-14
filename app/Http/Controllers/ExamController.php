<?php

namespace App\Http\Controllers;

use App\Events\TestCreated;
use App\Exam;
use App\Http\Requests\ExamRequest;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    protected $exam;

    /**
     * ExamController constructor.
     * @param $exam
     */
    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
    }

    public function store(ExamRequest $request)
    {
        $request->validated();
        $this->exam = $this->exam->add($request->all(), $request->user());
        return response()->json($this->exam, 200);
    }

    public function update(ExamRequest $request, $id)
    {
        $request->validated();
        $this->exam = $this->exam->edit($request->input(), $id);
        return response()->json($this->exam, 200);
    }

    public function destroy($id)
    {
        $this->exam = $this->exam->remove($id);
        return response($this->exam, 200);
    }
}
