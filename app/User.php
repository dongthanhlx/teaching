<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'role', 'created_at', 'updated_at', 'deleted_at', 'email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function find($id)
    {
        return $this->findOrFail($id);
    }

    public function add($input)
    {
        return $this->create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'role' => $input['role']
        ]);
    }

    public function editName($name, User $user)
    {
        $user->name = $name;
        $user->save();
    }

    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function info($detail = false)
    {
        $this->info = $this->detail()->get($detail ? '*': ['phone', 'school'])->first();
        return $this;
    }

    public function role()
    {
        return $this->role;
    }

    public function classes()
    {
        return $this->belongsToMany(
            ClassModel::class,
            'classes_students',
            'user_id',
            'class_id'
        );
    }

    public function collapseClassesInfo()
    {
        $classes = $this->classes()->get();

        foreach ($classes as $key => $class) {
            $teacher = $class->teacher()->get()->first();
            $class->teacher = $teacher;
            $class->teacher->info = $teacher->detail()->get()->first();
        }

        return $classes;
    }

    public function test()
    {
        $student = (new User())->find(9);
        $class = (new ClassModel())->find(1);
        return $class->hasStudent($student)->withPivot('created_at')->get()->first()->pivot->created_at;
    }

    public function classesDetail()
    {
        $classes = $this->collapseClassesInfo();

        foreach ($classes as $key => $class) {
            $classes[$key] = $class->with('exams')->findOrFail($class->id);
            $classes[$key]->joinTime = $class->hasStudent($this)->withPivot('created_at')->get()->first()->pivot->created_at;
        }

        return $classes;
    }

    public function teachClasses()
    {
        return $this->hasMany(ClassModel::class, 'teacher_id');
    }

    public function collapseTeachClasses()
    {
        $classes = $this->teachClasses()->get();

        foreach ($classes as $class) {
            $class->student_enrolled_length = $class->students()->count();
        }

        return $classes;
    }

    public function teachClassesDetail()
    {
        $classes = $this->teachClasses()->get();

        foreach ($classes as $key => $class) {
            $classes[$key] = $class->with('students', 'exams')->findOrFail($class->id);
        }

        return $classes;
    }

    public function notifications()
    {
        return $this->belongsToMany(
            Notification::class,
            'students_notifications',
            'student_id',
            'notification_id'
        );
    }

    public function readNotifications(ClassModel $class)
    {
        return $this->notifications()->where('class_id', '=', $class->id)->wherePivotNotNull('read_at');
    }

    public function unreadNotifications(ClassModel $class)
    {
        return $this->notifications()->where('class_id', '=', $class->id)->wherePivotNull('read_at');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'created_by');
    }

    public function questionsDetail()
    {
        $questions = $this->questions()->get();

        foreach ($questions as $key => $question) {
            $questions[$key] = $question->with('answers', 'tags')->find($question->id);
        }

        return $questions;
    }

    public function testSubjects()
    {
        return $this->hasMany(TestSubject::class, 'created_by');
    }

    public function testSubjectsDetail()
    {
        $testSubjects = $this->testSubjects()->get();

        foreach ($testSubjects as $key => $testSubject) {
            $testSubjects[$key] = $testSubject->with('tags')->findOrFail($testSubject->id);
            $testSubjects[$key]->questions_length = $testSubject->questions()->count();
        }

        return $testSubjects;
    }
}
