<?php

namespace App\Http\Controllers;

use App\TestSubject;
use Illuminate\Http\Request;

class TestSubjectController extends Controller
{
    protected $testSubject;

    /**
     * TestSubjectController constructor.
     * @param $testSubject
     */
    public function __construct(TestSubject $testSubject)
    {
        $this->testSubject = $testSubject;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->testSubject = $this->testSubject->add($request->all(), $request->user());

        return response()->json($this->testSubject, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->testSubject = $this->testSubject->edit($request->all(), $id);

        return response()->json($this->testSubject, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->testSubject->remove($id);

        return response()->json('Remove successfully', 200);
    }
}
