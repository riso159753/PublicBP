<?php

namespace App\Http\Controllers\Employee;

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


class HomeControllerEmployee extends Controller
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
        $order=Order::withTrashed()->where('status_id', '<',7)->where('visible',1)->orderBy('dtm_ukoncenia','desc')->get();
        $users=User::withTrashed()->select('id','name')->get();
        $statuses=Status::where('id','<',7)->get();

        if(session('CkdOrders'))
        {
            session()->forget('CkdOrders');
        }

        return view('employee.openOrders.index')->with('order',$order)->with('users',$users)->with('statuses',$statuses);
    }

       public function create()
    {
        $users=User::all();
        $materials=Materials::where('visible',1)->get();
        return view('employee.openOrders.create')->with('users',$users)->with('materials',$materials);
    }

    /**
     * storing form from openorders
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $this->AOrepository->createOrder($request);
        return back()->with('success', "Orders was successfully created.");
    }

    public function edit($locale,$id)
    {
        $order=Order::whereId($id)->first();
        $status=Status::all();
        $item=Item::where('order_id',$id)->where('visible',1)->get();
        $materials=Materials::where('visible',1)->get();
        return view('employee.openOrders.edit')->with('order',$order)->with('status',$status)->with('items',$item)->with('materialsAll',$materials);
    }

    public function update(Request $request)
    {
        if ($request->number==null)
        {
            return back()->with('error', "It is not allowed to have order with no item.");
        }
        $this->AOrepository->updateOrder($request);
        return back();
    }

    public function delete($locale,$id)
    {
        $this->AOrepository->deleteOrder($id);
        return back()->with('success','Post deleted successfully');
    }

    public function filter(Request $request)
    {
        $url = url()->current();
        $query=$request->query();
        unset($query['submit']);

        $query=$this->AOrepository->searchOrders($request);
        $order=Order::where('status_id', '<',7)->where('visible',1)->orderBy('dtm_ukoncenia','desc')->get();
        $users=DB::table('users')->select('id','name')->get();
        $statuses=Status::where('id','<',7)->get();
        $nameOfUser=User::withTrashed()->where('id',$request->customer)->value('name');

        if(session('CkdOrders'))
        {
            session()->forget('CkdOrders');
        }


        return view('employee.openOrders.filtered')->with('order',$query)->with('users',$users)->with('statuses',$statuses)->with('request',$request)->with('nameOfUser',$nameOfUser);
    }

    public function select(Request $request)
    {

        if($request->CkdOrders==null)  //check if nie je oznaceny ziadny checkbox, požaduje to array id, inak hodí chybu.
        {
            return back();
        }
        $order=Order::whereIn('id',$request->CkdOrders)->orderBy('dtm_ukoncenia','desc')->get();
        $statuses=Status::all();

        session(['CkdOrders'=>$request->CkdOrders]);
        return view('employee.openOrders.select')->with('order',$order)->with('statuses',$statuses);
    }

    public function updateSelection(Request $request)
    {
        $this->AOrepository->updateSelection($request);
        return $this->index();
    }

    public function nextStatus($locale,$id)
    {
        $this->AOrepository->nextStatus($id);


        return back();

    }

     public function exportActives()
    {
       return $this->AOrepository->exportActives();
    }

    public static function generateOptionList()
    {
        $materials=Materials::all();
        $html='';
        foreach ($materials as $material)
        {
            $html.='<option value="'.$material['id'].'">'.$material['name'].'</option>';
        }
        return $html;
    }

}
