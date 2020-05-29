<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;

class AutocompleteController extends Controller
{
    //for create controller - php artisan make:controller AutocompleteController

    function index()
    {
        return view('admin.openOrders.create');
    }

    public function getEmployees(Request $request){

        $search = $request->search;

        if($search == ''){
            $employees = User::orderby('name','asc')->select('id','name')->limit(5)->get();
        }else{
            $employees = User::orderby('name','asc')->select('id','name')->where('name', 'like', '%' .$search . '%')->limit(5)->get();
        }

        $response = array();
        foreach($employees as $employee){
            $response[] = array("value"=>$employee->id,"label"=>$employee->name);
        }

        echo json_encode($response);
        exit;
    }

}
