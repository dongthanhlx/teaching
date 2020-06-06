<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\AnswerRequest;

class AnswerController extends Controller
{
    protected $answer;

    /**
     * AnswerController constructor.
     * @param $answer
     */
    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnswerRequest $request)
    {
        $request->validated();
        $this->answer = $this->answer->add($request->all(), $request->user());
        return response()->json($this->answer, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnswerRequest $request, $id)
    {
        $request->validated();
        $this->answer = $this->answer->edit($request, $id);
        return response()->json($this->answer, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->answer = $this->answer->remove($id);
        return response()->json($this->answer, 200);
    }
}
