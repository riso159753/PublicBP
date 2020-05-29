<?php


namespace App\Http\Repositories\Admin;

use App\Http\Controllers\Controller;

use App\Mail\OrderCreated;
use App\Mail\OrderFinishedMail;
use App\Mail\PasswordMail;
use App\User_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SettingsRepository extends Controller
{

    private $user;

    /**
     * @param Order $user
     */
    public function __construct(User $user)
    {
        $this->user=$user;
    }

    public function updateInfo(Request $request)
    {
        $user=User::whereEmail(Auth::user()->email)->first();

        $user_info=User_info::wherePouzivatel_id($user['id'])->first();

        $user_info->meno=$request['name'];
        $user_info->telefon=$request['telefon'];

        $user_info->save();
        return back();
    }

    public function updatePass(Request $request)
    {
        $rules = [
            'oldPass' =>['required'],
            'password' => ['required', 'min:6'],
            'password_confirmation' => ['required', 'min:6','same:password'],
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.',
            'oldPass.required' => 'Old password is required',
            'password.required' => 'New password is required',
            'password_confirmation.same' => 'Passwords do not match',
            'password_confirmation.required' => 'Password confirmation is required',
            'password.min' => 'Password must be at least 6 characters long',
        ];

        $this->validate($request, $rules, $customMessages);


        $user = User::find(auth()->user()->id);
        if(!Hash::check($request['oldPass'], $user->password)){

            return back()->with('error','You have entered wrong password');

        }else{

           $user->password=Hash::make($request->password);
           $user->save();
            return back()->with('success','Password changed');
         }

    }

}
