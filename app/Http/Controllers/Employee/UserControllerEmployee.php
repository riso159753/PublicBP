<?php

namespace App\Http\Controllers\Employee;

use App\User;
use App\Http\Controllers\Controller;


class UserControllerEmployee extends Controller
{

    public function index()
    {
        $users=User::withTrashed()->get();

        return view('employee.users.index')->with('users',$users);
    }

}
