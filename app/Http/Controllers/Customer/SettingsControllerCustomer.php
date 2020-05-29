<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Admin\SettingsRepository;
use App\Order;
use App\Status;
use App\User;
use App\User_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingsControllerCustomer extends Controller
{
    protected $SettingsRepository;


    /**
     * Create a new controller instance.
     *
     * @param SettingsRepository $SettingsRepository
     */
    public function __construct(SettingsRepository $SettingsRepository)
    {
        $this->SettingsRepository = $SettingsRepository;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user=User::whereEmail(Auth::user()->email)->first();

        return view('customer.settings.index')->with('user', $user->user_info);
    }

    public function updateInfo(Request $request)
    {
        $this->SettingsRepository->updateInfo($request);
        return back();
    }

    public function updatePass(Request $request)
    {
        $this->SettingsRepository->updatePass($request);
        return back();
    }

}
