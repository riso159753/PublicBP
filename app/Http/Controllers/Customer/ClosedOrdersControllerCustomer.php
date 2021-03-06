<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Admin\ClosedOrdersRepository;
use App\Order;
use App\Status;
use App\User;
use App\User_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClosedOrdersControllerCustomer extends Controller
{
    protected $COrepository;


    /**
     * Create a new controller instance.
     *
     * @param ClosedOrdersRepository $COrepository
     */
    public function __construct(ClosedOrdersRepository $COrepository)
    {
        $this->COrepository = $COrepository;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $order=Order::where('status_id', '>',6)->where('visible',1)->where('pouzivatel_id', auth()->user()->id)->orderBy('dtm_ukoncenia','desc')->get();
        $users=User::withTrashed()->select('id','name')->get();
        $statuses=Status::all();
        return view('customer.closedOrders.index')->with('order', $order)->with('users',$users)->with('statuses',$statuses);
    }

    public function filter(Request $request)
    {
        $url = url()->current();
        $query=$request->query();
        unset($query['submit']);

        $query=$this->COrepository->searchOrders($request);
        $order=Order::where('status_id', '>',6)->where('visible',1)->orderBy('dtm_ukoncenia','desc')->get();
        $users=DB::table('users')->select('id','name')->get();
        $statuses=Status::all();
        $nameOfUser=User::withTrashed()->where('id',$request->customer)->value('name');

        if(session('CkdOrders'))
        {
            session()->forget('CkdOrders');
        }


        return view('customer.closedOrders.filtered')->with('order',$query)->with('users',$users)->with('statuses',$statuses)->with('request',$request)->with('nameOfUser',$nameOfUser);
    }




    public function exportClosed()
    {
        return $this->COrepository->exportClosedCustomer();
    }


}
