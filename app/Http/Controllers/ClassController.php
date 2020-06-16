<?php

namespace App\Http\Controllers;

use App\ClassModel;
use App\Events\TestCreated;
use App\Exam;
use App\Http\Requests\ClassRequest;
use App\User;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    protected $class;

    /**
     * ClassController constructor.
     * @param $class
     */
    public function __construct(ClassModel $class)
    {
        $this->class = $class;
    }

    public function store(ClassRequest $request)
    {
        $request->validated();
        $this->class = $this->class->add($request->all(), $request->user());
        return response()->json($this->class, 200);
    }

    public function update(ClassRequest $request, $id)
    {
        $request->validated();
        $this->class = $this->class->edit($request->all(), $id);
        return response()->json($this->class, 200);
    }

    public function delete($id)
    {
        $this->class = $this->class->remove($id);
        return response()->json($this->class, 200);
    }

    public function teacher()
    {
        $class = $this->class->find(1);
        return response()->json($class->teacher(), 200);
    }

    public function addExam(Request $request, ClassModel $class)
    {
//        $exam = (new Exam())->find($request->examId);
//        $class->addExam($exam);
//        $message = 'Bài kiểm tra đã được tạo thành công';
        event(new TestCreated($class));
        broadcast(new TestCreated($class))->toOthers();
        return 'Success';
    }

    public function classes(User $student)
    {
        $classes = $student->classes()->get(['name', 'code']);

        foreach ($classes as $class) {
            $class->teacher = $class->teacher()->get(['name', 'phone']);
        }

        return response()->json($classes, 200);
    }

    public function teachingClasses(User $teacher)
    {
        $classes = $teacher->teachingClasses()->get(['name', 'code']);

        foreach ($classes as $class) {
            $class->student_enrolled_length = $class->students()->count();
        }

        return response()->json($classes, 200);
    }

    public function classesDetail(User $user, ClassModel $class)
    {
         if ($class->hasStudent($user) == null) {
             return response()->json('You are not in this class', 200);
         }

         $teacher = $class->teacher()->get();
         $exams = $class->exams()->get();

         $class->teacher = $teacher;
         $class->exams = $exams;


    }
}
