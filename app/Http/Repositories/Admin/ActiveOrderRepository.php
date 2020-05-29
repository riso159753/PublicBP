<?php


namespace App\Http\Repositories\Admin;

use App\Exports\ActiveOrderExportCustomer;
use App\Exports\ClosedOrderExport;
use App\Http\Controllers\Controller;

use App\Item;
use App\Mail\OrderCreated;
use App\Mail\OrderFinishedMail;
use App\Mail\PasswordMail;
use App\Status;
use App\User_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Exports\ActiveOrderExport;
use Maatwebsite\Excel\Facades\Excel;

class ActiveOrderRepository extends Controller
{

    private $order;

    /**
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order=$order;
    }

    public function createOrder(Request $params)
    {
        $order= new Order();

        $order->pouzivatel_id=DB::table('users')->where('email',$params['customer'])->value('id');
        $name=User::whereId($order->pouzivatel_id)->value('name');
        $order->nazov_objednavky=$params['orderName'];

        $order->polozky=$params['items'];
        $order->popis=$params['description'];
        $order->pocet=$params['quantity'];
        $order->poznamka=$params['note'];
        $order->status_id=1;
        $order->dtm_vytvorenia=date("Y-m-d");
        $order->dtm_ukoncenia=$params['completionDate'];
        $order->visible=1;
        $order->save();

        $orderId=$order->id; // k Items

        $product=$params->product;
        $person=$params->person;
        $material=$params->material;
        $trim=$params->trim;
        $sidePanel=$params->sidePanel;
        $panel=$params->panel;
        $zip=$params->zip;
        $collar=$params->collar;
        $size=$params->size;
        $number=$params->number;
        for($count = 0; $count < count($number); $count++)
        {
            $data = array(
                'order_id'=>$orderId,
                'product' =>$product[$count],
                'person' =>$person[$count],
                'material' =>$material[$count],
                'trim' =>$trim[$count],
                'sidePanel' =>$sidePanel[$count],
                'panel' =>$panel[$count],
                'zip' =>$zip[$count],
                'collar' =>$collar[$count],
                'size' =>$size[$count],
                'number' =>$number[$count],
                'visible'=>1
            );
            $insert_data[] = $data;
        }


        Item::insert($insert_data);

        $origin=User_info::whereId($order->pouzivatel_id)->value('krajina');

        $order=date("dmy",strtotime($order->dtm_vytvorenia)).$origin.sprintf("%05s", $order->id);

        $info=array("order"=>$order,"name"=>$name);
        Mail::to($params['customer'])->send(new OrderCreated($info));

        return $order;
    }

    public function updateOrder(Request $request)
    {

        $order=Order::withTrashed()->where('id',$request['id'])->first();

        $order->pouzivatel_id=$request['pouzivatel_id'];

        if ($order->status_id<7 && $request['status']>6)
        {
            $origin=User_info::whereId($request['pouzivatel_id'])->value('krajina');

            $person=User::withTrashed()->select('name','email')->where('id',$request['pouzivatel_id'])->first();

            $orderID=date("dmy",strtotime($order->dtm_vytvorenia)).$origin.sprintf("%05s", $order->id);

            $info=array("order"=>$orderID,"name"=>$person->name,"trackNum"=>$request['trackingNumber']);
            Mail::to($person->email)->send(new OrderFinishedMail($info));
        }


        $order->nazov_objednavky=$request['orderName'];
        $order->polozky=$request['items'];
        $order->popis=$request['description'];
        $order->pocet=$request['quantity'];
        $order->poznamka=$request['note'];
        $order->dtm_vytvorenia=$request['confirmationDate'];
        $order->dtm_ukoncenia=$request['completionDate'];
        $order->status_id=$request['status'];
        $order->tracking_num=$request['trackingNumber'];
        $order->faktura=$request['invoice'];

        $order->save();

        $orderId=$order->id;

        $product=$request->product;
        $person=$request->person;
        $material=$request->material;
        $trim=$request->trim;
        $sidePanel=$request->sidePanel;
        $panel=$request->panel;
        $zip=$request->zip;
        $collar=$request->collar;
        $size=$request->size;
        $number=$request->number;
        $itemId=$request->idItem;

        $count = 0;
        Item::where('order_id',$request->id)->whereNotIn('id',$itemId)->update(['visible'=>0]); //vymazávanie itemov. V prípade,že sa item neodošle, t.j. user ho vymaze, tak sa nastaví 0 na visible

        for($count; $count < count($itemId); $count++)
        {
            $data = array(

                'order_id'=>$orderId,
                'product' =>$product[$count],
                'person' =>$person[$count],
                'material' =>$material[$count],
                'trim' =>$trim[$count],
                'sidePanel' =>$sidePanel[$count],
                'panel' =>$panel[$count],
                'zip' =>$zip[$count],
                'collar' =>$collar[$count],
                'size' =>$size[$count],
                'number' =>$number[$count],

            );
            $update_data[] = $data;
            Item::whereId($itemId[$count])->update($update_data[$count]);
        }

        if(count($number)>$count)
        {

            for($count; $count < count($number); $count++)
            {
                $data = array(

                    'order_id'=>$orderId,
                    'product' =>$product[$count],
                    'person' =>$person[$count],
                    'material' =>$material[$count],
                    'trim' =>$trim[$count],
                    'sidePanel' =>$sidePanel[$count],
                    'panel' =>$panel[$count],
                    'zip' =>$zip[$count],
                    'collar' =>$collar[$count],
                    'size' =>$size[$count],
                    'number' =>$number[$count],
                    'visible'=>1
                );
                $insert_data[] = $data;


            }
            Item::insert($insert_data);
        }



    }


    public function deleteOrder($id)
    {
        $order=Order::whereId($id)->first();
        $order->visible=0;
        $order->save();
    }

    public function searchOrders(Request $request)
    {
        $params = $request->except('_token');

        if((auth()->user()->role)=="customer")
        {
            $params['origin'] ="AOrepositoryCustomer";
        }else
        {
            $params['origin'] ="AOrepository";
        }

        $query = Order::filter($params)->get();

       return $query;
    }

    public function updateSelection(Request $request)
    {
        $selection=session('CkdOrders');

        if($request->status!=null)
        {
            Order::whereIn('id', $selection)->update(['status_id'=>$request->status]);
        }

        if($request->completionDate!=null)
        {
            Order::whereIn('id', $selection)->update(['dtm_ukoncenia'=>$request->completionDate]);
        }
    }

    public function nextStatus($id)
    {
        Order::whereId($id)->increment('status_id');
        $order=Order::whereId($id)->first();

        if($order->status_id==7)
        {
            $origin=User_info::whereId($order->pouzivatel_id)->value('krajina');
            $person=User::select('name','email')->where('id',$order->pouzivatel_id)->first();

            $orderID=date("dmy",strtotime($order->dtm_vytvorenia)).$origin.sprintf("%05s", $order->id);

            $info=array("order"=>$orderID,"name"=>$person->name,"trackNum"=>null);
            Mail::to($person->email)->send(new OrderFinishedMail($info));
        }
    }


    public function exportActives()
    {
       return Excel::download(new ActiveOrderExport(), 'activeOrders.xlsx');
    }

    public function exportActivesCustomer()
    {
        return Excel::download(new ActiveOrderExportCustomer(), 'activeOrders.xlsx');
    }





}
