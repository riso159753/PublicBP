<?php

namespace App\Http\Controllers\Admin;

use App\Http\Repositories\Admin\UserRepository;
use App\User;
use App\User_info;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{

   protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;
    }

    public function index()
    {
        $users=User::withTrashed()->get();

        return view('admin.users.index')->with('users',$users);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function save(Request $request)
    {
        $params=$request->except('_token');
        $user=$this->userRepository->createUser($request, $params);
        return back()->with('success', "Užívateľ bol úspešne pridasný.");
    }

    public function delete($locale,$id)
    {
        if(Auth::user()->id!=$id){
            $user=$this->userRepository->deleteUser($id);
            return back()->with('success', $user->name." "."was deactivated!");
        }else
        {
            return back()->with('error', "User can not deactivate yourself!");
        }

    }
    public function activate($locale,$id)
    {
        $user=$this->userRepository->activateUser($id);

        return back()->with('success',  $user->name." was activated!");
    }
}
