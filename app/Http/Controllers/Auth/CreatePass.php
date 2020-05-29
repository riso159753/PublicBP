<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use function Composer\Autoload\includeFile;

class CreatePass extends Controller
{

    public function index()
    {

        return view('createPass');
    }
    public function save(Request $request)
    {
        $this->validate(request(),[
            'email' => ['required', 'string', 'email', 'max:255'], //spravna verzia, bez unique kvoli testovaniu //7.3.2020
            'password' => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'min:6'],
        ]);

        $user=User::whereRemember_token($request->token2)->first();
        $to = Carbon::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s"));
        $from = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at);

        $diff_in_days = $to->diffInDays($from);

        if($user->email==$request->email && $diff_in_days<8)
        {
            $user->password=Hash::make($request->password);
            $user->remember_token="";
            $user->save();
            return back()->with('success', "Password created.");
        }


        return back()->with('error', "Password was not created.");
    }
}
