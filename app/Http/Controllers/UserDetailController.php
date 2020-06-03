<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDetailRequest;
use App\User;
use Illuminate\Http\Request;

class UserDetailController extends Controller
{
    public function update(UserDetailRequest $request, $id)
    {
        $validated = $request->validated();
        if(!$validated) return null;

        $userDetail = User::findOrFail($id);
        $userDetail->birthday = $request->birthday;
        $userDetail->school = $request->school;
        $userDetail->phone = $request->phone;
        $userDetail->address = $request->address;
        $userDetail->class = $request->class;
        $userDetail->save();

        return $userDetail;
    }
}
