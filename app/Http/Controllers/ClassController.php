<?php

namespace App\Http\Controllers;

use App\ClassModel;
use App\Http\Requests\ClassRequest;
use Illuminate\Http\Request;

class ClassController extends Controller
{

    protected $class;

    /**
     * ClassController constructor.
     * @param $class
     */
    public function __construct()
    {
        $this->class = new ClassModel();
    }


    public function store(ClassRequest $request)
    {
        $validated = $request->validated();

        if (! $validated) return null;

        $result = $this->class->add($request);
        return response()->json($result, 200);
    }

    public function update(ClassRequest $request, $id)
    {
        $validated = $request->validated();

        if (! $validated) return null;

        $result = $this->class->edit($request, $id);
        return response()->json($result, 200);
    }

    public function delete($id)
    {
        $result = $this->class->remove($id);

        return response()->json($result, 200);
    }
}
