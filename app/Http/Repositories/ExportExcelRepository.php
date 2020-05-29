<?php


namespace App\Http\Repositories\Admin;

use App\Http\Controllers\Controller;

use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\User;
use Maatwebsite\Excel\Facades\Excel;


class ExportExcelRepository
{


    function excel()
    {
        $order=Order::where('status_id', '<',7)->where('visible',1)->orderBy('dtm_ukoncenia','desc')->get();
        $statuses=Status::all();

        foreach ($order as $row)
        {
            $row->pouzivatel_id=$row->user->name;
            $row->status_id=$statuses[$row->status_id]->nazov;
            $row->dtm_vytvorenia=date("d-m-Y",strtotime($row->dtm_vytvorenia));
            $row->dtm_ukoncenia=date("d-m-Y",strtotime($row->dtm_ukoncenia));

        }

        $customer_data = $order->toArray();
        $customer_array[] = array('Order ID', 'Customer', 'Order Name', 'Total number of pieces', 'Confirmation Date', 'Expected date of completion', 'Status');
        foreach($customer_data as $customer)
        {
            dd($customer);
            $customer->id=date("dmy",strtotime($customer->dtm_vytvorenia)).$customer->user->user_info->krajina.sprintf("%05s", $customer->id);
            dd($customer->id);
            $customer_array[] = array(
                'Order ID'  => $customer->id,
                'Customer'   => $customer->pouzivatel_id,
                'Order Name'    => $customer->nazov_objednavky,
                'Total number of pieces'  => $customer->pocet,
                'Confirmation Date'   => $customer->dtm_vytvorenia,
                'Expected date of completion'  => $customer->dtm_ukoncenia,
                'Status'  => $customer->status_id

            );
        }
        Excel::create('Active Orders', function($excel) use ($customer_array){
            $excel->setTitle('Active Orders');
            $excel->sheet('Active Orders', function($sheet) use ($customer_array){
                $sheet->fromArray($customer_array, null, 'A1', false, false);
            });
        })->download('xlsx');
    }
}
