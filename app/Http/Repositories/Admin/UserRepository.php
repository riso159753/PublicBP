<?php


namespace App\Http\Repositories\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\User_info;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\PasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class UserRepository extends Controller
{
    private $model;
    private $modelUserInfo;


    /**
     * @param User $model
     * @param User_info $modelUserInfo
     */
    public function __construct(User $model, User_info $modelUserInfo)
    {
       $this->model=$model;
       $this->modelUserInfo=$modelUserInfo;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listUsers(string $order = 'id', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->model->all($columns, $order, $sort);
    }
    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findUserById(int $id)
    {
        try {
            return $this->model->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
    }



    /**
     * @param array $params
     * @return User_info|mixed
     * @throws \Illuminate\Validation\ValidationException
     */

    public function createUser(Request $params)
    {
        $this->validate(request(),[
        'customer' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], //spravna verzia, bez unique kvoli testovaniu //7.3.2020
           // 'email' => ['required', 'string', 'email', 'max:255'],
        'contact' => ['nullable', 'regex:([A-z])', 'max:255'],
        'role' => ['required'],
    ]);


        $user=new User();
        $userInfo=new User_info();

        $user->name= $params['customer'];
        $user->email= $params['email'];
        $user->role= $params['role'];
        $token=Str::random(60);
        $user->remember_token=$token;

        $userInfo->meno= $params['contact'];
        $userInfo->krajina= $params['origin'];
        $userInfo->telefon= $params['mobile'];


        $user->save();

        $userInfo->pouzivatel_id= $user->id;

        $userInfo->save();


        $info=array("name"=>$user->name,"token"=>$token);
        Mail::to($user->email)->send(new PasswordMail($info));

        return $user;
        //return $user; ak chcem napr. vypisat koho som vytvoril, napr. ako alert.
    }


    public function deleteUser($id)
    {
        $user=User::whereId($id)->first();
        $user->deleted_at=now();
        $user->save();
        return $user;
    }

    public function activateUser($id)
    {
        $user=User::withTrashed()->where('id',$id)->first();
        $user->restore();
        return $user;
    }
}
