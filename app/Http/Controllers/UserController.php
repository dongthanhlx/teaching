<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;
    use Authenticatable;
    /**
     * UserController constructor.
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return csrf_token();
    }
}
