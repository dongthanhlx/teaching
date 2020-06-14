<?php

namespace App\Broadcasting;

use App\ClassModel;
use App\User;

class ClassChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param User $user
     * @param ClassModel $class
     * @return boolean
     */
    public function join(User $user, ClassModel $class)
    {
        var_dump($user->name);
        var_dump($class->name);
        echo 'dong thanh';
        $class = (new ClassModel())->find($class->id);
        $searchStudent = $class->hasStudent($user);
        return $searchStudent !== null;
    }
}
