<?php

namespace App\Exports;

use App\Order;
use App\Status;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Sheet;

class ClosedOrderExport implements FromCollection, ShouldAutoSize, WithEvents
{
    public function collection()
    {
        $order=Order::where('status_id', '>',6)->where('visible',1)->orderBy('dtm_ukoncenia','desc')->get(['id','pouzivatel_id','nazov_objednavky','pocet','dtm_vytvorenia','dtm_ukoncenia','status_id','polozky','popis','poznamka','tracking_num','faktura']);
        $statuses=Status::all();

        foreach ($order as $row)
        {
            $row->pouzivatel_id=$row->user->name;
            $row->status_id=$statuses[$row->status_id-1]->nazov;
            $row->dtm_vytvorenia=date("d-m-Y",strtotime($row->dtm_vytvorenia));
            $row->dtm_ukoncenia=date("d-m-Y",strtotime($row->dtm_ukoncenia));
            $row->orderID=date("dmy",strtotime($row->dtm_vytvorenia)).$row->user->user_info->krajina.sprintf("%05s", $row->id);
        }

        $order->toArray();
        $orderArr[]=array('Order ID',
            'Customer',
            'Order Name',
            'Total number of pieces',
            'Confirmation Date',
            'Date of completion',
            'Status',
            'Items',
            'Description',
            'Note',
            'Tracking number',
            'Invoice');
        foreach ($order as $row)
        {
            $orderArr[]=array(
                'Order ID'=>$row['orderID'],
                'Customer'=>$row['pouzivatel_id'],
                'Order Name'=>$row['nazov_objednavky'],
                'Total number of pieces'=>$row['pocet'],
                'Confirmation Date'=>$row['dtm_vytvorenia'],
                'Date of completion'=>$row['dtm_ukoncenia'],
                'Status' =>$row['status_id'],
                'Items'=>$row['polozky'],
                'Description'=>$row['popis'],
                'Note'=>$row['poznamka'],
                'Tracking number'=>$row['tracking_num'],
                'Invoice'=>$row['faktura']
            );
        }

        return collect($orderArr);

    }



    public function registerEvents(): array
    {

        $styleArray = [
            'font' => [
                'bold' => true,
            ]
        ];

        return [
            AfterSheet::class    => function(AfterSheet $event) use ($styleArray)
            {
                $cellRange = 'A1:L1'; // All headers
                //$event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setName('Calibri');
                $event->sheet->getStyle($cellRange)->ApplyFromArray($styleArray);

            },
        ];
    }



}
