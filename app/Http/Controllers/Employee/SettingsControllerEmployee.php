<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Employee\SettingsRepositoryEmployee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsControllerEmployee extends Controller
{
    protected $SettingsRepositoryEmployee;


    /**
     * Create a new controller instance.
     *
     * @param SettingsRepositoryEmployee $SettingsRepositoryEmployee
     */
    public function __construct(SettingsRepositoryEmployee $SettingsRepositoryEmployee)
    {
        $this->SettingsRepositoryEmployee = $SettingsRepositoryEmployee;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user=User::whereEmail(Auth::user()->email)->first();

        return view('employee.settings.index')->with('user', $user->user_info);
    }

    public function updateInfo(Request $request)
    {
        $this->SettingsRepositoryEmployee->updateInfo($request);
        return back();
    }

    public function updatePass(Request $request)
    {
        $this->SettingsRepositoryEmployee->updatePass($request);
        return back();
    }

}
