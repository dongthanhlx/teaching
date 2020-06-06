<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDetailRequest;
use App\UserDetail;

class UserDetailController extends Controller
{
    protected $userDetail;

    /**
     * UserDetailController constructor.
     * @param $userDetail
     */
    public function __construct(UserDetail $userDetail)
    {
        $this->userDetail = $userDetail;
    }

    public function store(UserDetailRequest $request)
    {
        $request->validated();
        $this->userDetail = $this->userDetail->add($request->all(), $request->user());
        return response($this->userDetail, 200);
    }

    public function update(UserDetailRequest $request)
    {
        $request->validated();
        $this->userDetail = $this->userDetail->edit($request->all(), $request->user());
        return response()->json($this->userDetail, 200);
    }
}
