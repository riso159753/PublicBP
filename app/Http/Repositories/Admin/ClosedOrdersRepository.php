<?php


namespace App\Http\Repositories\Admin;

use App\Exports\ClosedOrderExport;
use App\Exports\ClosedOrderExportCustomer;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClosedOrdersRepository extends Controller
{

    private $order;

    /**
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order=$order;
    }

    public function searchOrders(Request $request)
    {
        $params = $request->except('_token');
        if((auth()->user()->role)=="customer")
        {
            $params['origin'] ="COrepositoryCustomer";
        }else{
            $params['origin'] ="COrepository";
        }

        $query = Order::filter($params)->get();

        return $query;
    }

    public function exportClosed()
    {
        return Excel::download(new ClosedOrderExport(), 'closedOrders.xlsx');
    }

    public function exportClosedCustomer()
    {
        return Excel::download(new ClosedOrderExportCustomer(), 'closedOrders.xlsx');
    }



}
