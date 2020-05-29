@extends('customer.app')

@section('content')

    <div class="app-title">
        <div>

            <h1><i class="fa fa-briefcase"></i> {{ __('Edit order') }}</h1>
            <p> {{ __('Edit order') }}</p>
        </div>
        <a href="{{ route('customer.openOrders.index', app()->getLocale()) }}" class="btn btn-primary pull-right">{{ __('Orders') }}</a>

    </div>
    <div class="col-md-12">

            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    <div class="tile">


                        <h3 class="tile-title">{{ __('Order Information') }}</h3>
                        <hr>
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="customer">{{ __('Customer') }}</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            placeholder="{{ __('Enter customer name') }}"
                                            id="customer"
                                            name="customer"
                                            value="{{ old('customer',$order->user->name) }}"
                                            readonly
                                        />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="orderName">{{ __('Name of order') }} *</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            placeholder="{{ __('Enter name of order') }}"
                                            id="orderName"
                                            name="orderName"
                                            value="{{ old('orderName', $order->nazov_objednavky) }}"
                                            required
                                            readonly
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="items">{{ __('List of Items') }} *</label>
                                <textarea name="items" id="items" rows="6" class="form-control" maxlength="300" required  readonly>{{$order->polozky}}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="description">{{ __('Description') }}</label>
                                        <textarea name="description" id="description" rows="6" maxlength="300" class="form-control"  readonly>{{$order->popis}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="note">{{ __('Note') }}</label>
                                        <textarea name="note" id="note" rows="6" class="form-control" maxlength="500" readonly>{{$order->poznamka}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="quantity">{{ __('Total quantity') }} *</label>
                                        <input
                                            class="form-control"
                                            type="number"
                                            placeholder="{{ __('Enter total quantity') }}"
                                            id="quantity"
                                            name="quantity"
                                            value="{{ old('quantity',$order->pocet) }}"
                                            min="1"
                                            required
                                            readonly
                                        />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleSelect1">{{ __('Status') }}</label>
                                        <select class="form-control" id="status" name="status" readonly>
                                            <option value="{{$order->status_id}}">{{ __($order->status->nazov) }}</option>
                                            {{$i=1}}
                                            @foreach($status as $statuses)
                                                <option value="{{$i++}}">{{ __($statuses->nazov) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="quantity">{{ __('Date of confirmation') }}</label>
                                        <input
                                            class="form-control"
                                            type="date"
                                            id="confirmationDate"
                                            name="confirmationDate"
                                            value="{{ old('confirmationDate',$order->dtm_vytvorenia) }}"
                                            readonly
                                        />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="orderName">{{ __('Date of completion') }} *</label>
                                        <input
                                            class="form-control"
                                            type="date"
                                            id="completionDate"
                                            name="completionDate"
                                            value="{{ old('completionDate',$order->dtm_ukoncenia) }}"
                                            required

                                            readonly
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="quantity">{{ __('Tracking number') }}</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            id="trackingNumber"
                                            name="trackingNumber"
                                            value="{{ old('confirmationDate',$order->tracking_num) }}"
                                            autocomplete="off"
                                            readonly
                                        />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="orderName">{{ __('Invoice') }}</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            id="invoice"
                                            name="invoice"
                                            value="{{ old('completionDate',$order->faktura) }}"
                                            autocomplete="off"
                                            readonly
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <div class="row d-print-none mt-2">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    <div class="tile">

                        <h3 class="tile-title">{{ __('Order Items') }}</h3>
                        <hr>
                        <div class="tile-body">
                            <div class="row">

                                <div class="table-responsive">
                                    <div class="container-fluid">
                                        <table class="table table-bordered  " id="dynamic_field">
                                            <thead>
                                            <tr>
                                                <th >{{ __('Name of product') }}</th>
                                                <th >{{ __('Name of player/ Number') }}</th>
                                                <th >{{ __('Material') }}</th>
                                                <th >{{ __('Trim') }}</th>
                                                <th >{{ __('Side panel') }}</th>
                                                <th >{{ __('Panel') }}</th>
                                                <th >{{ __('Zip') }}</th>
                                                <th >{{ __('Collar') }}</th>
                                                <th style="width: 6%">{{ __('Size') }}</th>
                                                <th style="width: 7%">{{ __('Number') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($items as $row)
                                                <tr>
                                                    <td><input type="text" name="product[]" class="form-control" value="{{$row->product}}" readonly></td>
                                                    <td><input type="text" name="person[]" class="form-control" value="{{$row->person}}" readonly></td>
                                                    <td><select  class="form-control"  id="material" name="material[]" readonly>
                                                            <option  value="{{$row->material}}">@if($row->material){{ __($row->materials->name) }}@endif</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="hidden" name="trim[{{$loop->index}}]" value="0" readonly><input type="checkbox" name="trim[{{$loop->index}}]" class="form-control" value="1" @if($row->trim==1)checked @endif onclick="this.checked=!this.checked;"> </td>
                                                    <td><select name="sidePanel[]" class="form-control" id="sidePanel" readonly>
                                                            <option  value="{{$row->sidePanel}}">@if($row->sidePanel){{ __($materialsAll[$row->sidePanel-1]->name) }}@endif</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="hidden" name="panel[{{$loop->index}}]" value="0" readonly><input type="checkbox" name="panel[{{$loop->index}}]" class="form-control" value="1" @if($row->panel==1)checked @endif onclick="this.checked=!this.checked;"></td>
                                                    <td><input type="hidden" name="zip[{{$loop->index}}]" value="0" readonly><input type="checkbox" name="zip[{{$loop->index}}]" class="form-control" value="1" @if($row->zip==1) checked @endif onclick="this.checked=!this.checked;"></td>
                                                    <td>
                                                        <select name="collar[]" class="form-control" readonly>
                                                            <option  value="{{$row->collar}}">@if($row->collar){{ __($materialsAll[$row->collar-1]->name) }}@endif</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="size[]" class="form-control" value="{{$row->size}}" readonly></td>
                                                    <td><input type="number" name="number[]" class="form-control" value="{{$row->number}}" required readonly></td>

                                                </tr>

                                            @endforeach
                                            </tbody>
                                            <tfoot>

                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tile-footer">
                                <div class="row d-print-none mt-2">
                                    <div class="col-12 text-right">
                                        <a class="btn btn-danger" @if($order->status_id<7) href="{{ route('customer.openOrders.index', app()->getLocale()) }}" @else href="{{route('customer.closedOrders.index', app()->getLocale())}}" @endif><i class="fa fa-fw fa-lg fa-arrow-left"></i>{{ __('Go Back') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        @endsection


