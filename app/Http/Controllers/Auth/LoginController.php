<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

            if (auth()->user()->role == "admin") {
                return redirect()->intended(route('admin.openOrders.index', app()->getLocale()));
            }
            elseif (auth()->user()->role == "employee") {

                return redirect()->intended(route('employee.openOrders.index', app()->getLocale()));
            }
            elseif (auth()->user()->role == "customer") {

                return redirect()->intended(route('customer.openOrders.index', app()->getLocale()));
            }
        else
        {
            return redirect()->route('login', app()->getLocale());
        }
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        return redirect()->route('login', app()->getLocale());

    }
}
