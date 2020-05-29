<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Admin\ActiveOrderRepository;
use App\Item;

use App\Order;
use App\Status;
use App\User;
use App\Materials;
use App\User_info;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeControllerCustomer extends Controller
{
    protected $AOrepository;


    /**
     * Create a new controller instance.
     *
     * @param ActiveOrderRepository $AOrepository
     */
    public function __construct(ActiveOrderRepository $AOrepository)
    {
        $this->AOrepository=$AOrepository;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $order=Order::withTrashed()->where('status_id', '<',7)->where('visible',1)->where('pouzivatel_id', auth()->user()->id)->orderBy('dtm_ukoncenia','desc')->get();
        $users=User::withTrashed()->select('id','name')->get();
        $statuses=Status::all();

        if(session('CkdOrders'))
        {
            session()->forget('CkdOrders');
        }

        return view('customer.openOrders.index')->with('order',$order)->with('users',$users)->with('statuses',$statuses);
    }




    public function edit($locale,$id)
    {
        $order=Order::whereId($id)->first();
        $status=Status::all();
        $item=Item::where('order_id',$id)->where('visible',1)->get();
        $materials=Materials::all();
        return view('customer.openOrders.edit')->with('order',$order)->with('status',$status)->with('items',$item)->with('materialsAll',$materials);
    }




    public function filter(Request $request)
    {
        $url = url()->current();
        $query=$request->query();
        unset($query['submit']);

        $query=$this->AOrepository->searchOrders($request);

        $order=Order::where('status_id', '<',7)->where('visible',1)->orderBy('dtm_ukoncenia','desc')->get();
        $users=DB::table('users')->select('id','name')->get();
        $statuses=Status::all();
        $nameOfUser=User::withTrashed()->where('id',$request->customer)->value('name');

        if(session('CkdOrders'))
        {
            session()->forget('CkdOrders');
        }


        return view('customer.openOrders.filtered')->with('order',$query)->with('users',$users)->with('statuses',$statuses)->with('request',$request)->with('nameOfUser',$nameOfUser);
    }



     public function exportActives()
    {
       return $this->AOrepository->exportActivesCustomer();
    }


}
