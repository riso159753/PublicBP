@extends('employee.app')

@section('content')

    <div class="app-title">
        <div>
            <h1><i class="fa fa-briefcase"> </i> {{ __('Closed Orders') }}</h1>
            <p>{{ __('Closed Orders') }}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <div class="dropdown ahref">
                <button class="btn btn-primary dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-lg fa-filter"></i> {{__('Filter')}}
                </button>

                <div class="dropdown-menu dropdown-menu-right filter mt-5 mt-md-0">
                    <form action="{{ route('employee.closedOrders.filter', app()->getLocale()) }}" method="get" role="form" class="px-4 py-3">

                        <div class="form-group">
                            <label for="customer">{{ __('Customer') }}</label>
                            <input class="form-control" data-live-search="true" list="customers" id="customer"  placeholder="{{__('Start typing')}}" autocomplete="off" @if( ! empty($request->customer)) value="{{$nameOfUser}}"  @endif>
                            <datalist id="customers">
                                @foreach($users as $user)
                                    <option data-value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </datalist>
                            @if( ! empty($request->customer))  <input type="hidden" name="customer" id="customer-hidden" value="{{$request->customer}}">
                            @else<input type="hidden" name="customer" id="customer-hidden">  @endif


                        </div>
                        <div class="form-group">
                            <label for="customer">{{ __('Order Name') }}</label>
                            <input class="form-control" list="orders" data-live-search="true" id="orderName" name="orderName" placeholder="{{__('Start typing')}}" autocomplete="off" @if( ! empty($request->orderName)) value="{{$request->orderName}}"  @endif >
                            <datalist id="orders">
                                @if(empty($allOrders)){{--allOrders je premenná s všetkými objednávkami, je to kvoli názvom objednávkam, inak by sa zobrali iba názvy filtrovaných obj.--}}
                                @foreach($order  as $orders)
                                    <option value="{{$orders->nazov_objednavky}}">{{$orders->nazov_objednavky}}</option>
                                @endforeach
                                @else
                                    @foreach($allOrders  as $orders)
                                        <option value="{{$orders->nazov_objednavky}}">{{$orders->nazov_objednavky}}</option>
                                    @endforeach
                                @endif
                            </datalist>


                        </div>
                        <div class="form-group">
                            <label for="status">{{ __('Status') }}</label>
                            <select class="form-control" id="status" name="status">
                                <option @if( ! empty($request->status)) value="{{$request->status}}"  @endif >{{--ak je nastaveny filter, tak sa nastavi value --}}
                                    @if( ! empty($request->status)){{--ak je nastaveny filter, tak sa vypise hodnota ako default na zoznam--}}
                                    {{__($statuses[$request->status-1]->nazov)}}
                                    @endif
                                </option>
                                @if( ! empty($request->status))<option></option>@endif
                                @foreach($statuses as $status){{--vypis statusov--}}
                                <option value="{{$status->id}}">{{ __($status->nazov) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for=""><strong>{{ __('Search by completion date')}}</strong></label>
                            <div class="row pb-1 h-100">
                                <div class="col-2 my-auto">
                                    <label  for="">{{ __('From')}}:</label>
                                </div>
                                <div class="col-10">
                                    <input class="form-control"  type="date" name="complFrom" @if( ! empty($request->complFrom)) value="{{$request->complFrom}}"  @endif >
                                </div>
                            </div>
                            <div class="row h-100">
                                <div class="col-2 my-auto">
                                    <label  for="">{{ __('To')}}:</label>
                                </div>
                                <div class="col-10">
                                    <input class="form-control" type="date" name="complTo" @if( ! empty($request->complTo)) value="{{$request->complTo}}"  @endif >
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for=""><strong>{{ __('Search by confirmation date')}}</strong></label>
                            <div class="row pb-1 h-100">
                                <div class="col-2 my-auto">
                                    <label for="">{{ __('From')}}:</label>
                                </div>
                                <div class="col-10">
                                    <input class="form-control" type="date" name="confiFrom" @if( ! empty($request->confiTo)) value="{{$request->confiTo}}"  @endif>
                                </div>
                            </div>

                            <div class="row h-100">
                                <div class="col-2 my-auto">
                                    <label for="">{{ __('To')}}:</label>
                                </div>
                                <div class="col-10">
                                    <input class="form-control" type="date" name="confiTo" @if( ! empty($request->confiTo)) value="{{$request->confiTo}}"  @endif>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown-divider"></div>

                        <button type="submit"  class="btn btn-primary">{{ __('Filter')}}</button>
                        <a id="drpClose" href="{{ route('employee.closedOrders.index' , app()->getLocale()) }}" class="btn btn-secondary">{{ __('Cancel')}}</a>

                    </form>
                </div>
            </div>
            <a href="{{ route('employee.export_excel.exportClosed', app()->getLocale()) }}" class="btn btn-primary ml-2 ml-md-2"> <i class="fa fa-fw fa-lg fa-file-excel-o"></i>{{ __('Excel') }}</a>


        </ul>


    </div>

    <div class="row ">
        <div class="col-md-12 col-sm-12">
            <div class="tile">
                <div class="tile-body">
                </div>
                <div class="table-responsive">

                    <div class="container-fluid">
                        <table data-order='[]' class="table table-hover w-100 table-bordered " id="sampleTable">
                            <thead>
                            <tr>
                                <th class="text-center">{{ __('Order ID') }}</th>
                                <th class="text-center">{{ __('Customer') }}</th>
                                <th class="text-center">{{ __('Order Name') }}</th>
                                <th class="text-center">{{ __('Total number of pieces') }}</th>
                                <th class="text-center">{{ __('Confirmation Date') }}</th>
                                <th class="text-center">{{ __('Expected date of completion')}}  </th>
                                <th class="text-center">{{ __('Status') }}  </th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($order as $row)
                                <tr>

                                    <td><a href="{{route('employee.closedOrders.edit', ['id'=> $row->id,'locale'=>app()->getLocale()]) }}"><strong>{{date("dmy",strtotime($row->dtm_vytvorenia)).$row->user->user_info->krajina.sprintf("%05s", $row->id)}}</strong></a></td>
                                    <td>{{$row->user->name}}</td>
                                    <td>{{$row->nazov_objednavky}}</td>
                                    <td>{{$row->pocet}}</td>
                                    <td>{{date("d.m.Y",strtotime($row->dtm_vytvorenia))}}</td>
                                    <td>{{date("d.m.Y",strtotime($row->dtm_ukoncenia))}}</td>
                                    @if($row->status->nazov=="Dispatched")
                                        <td style="color: #cd1920"><strong>{{ __($row->status->nazov) }}</strong></td>
                                    @elseif($row->status->nazov=="Invoiced")
                                        <td style="color: #0ba938"><strong>{{ __($row->status->nazov) }}</strong></td>
                                    @endif

                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script type="text/javascript" src="{{asset("/js/plugins/jquery.dataTables.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("/js/plugins/dataTables.bootstrap.min.js")}}"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable(
            {}
        );
    </script>



    <script> //script k datalistu, aby sa posielala data-value hodnota. S klasickym value to vypisuje do input fieldu aj samotné id-nechcený stav
        document.querySelector('input[list]').addEventListener('input', function(e) {
            var input = e.target,
                list = input.getAttribute('list'),
                options = document.querySelectorAll('#' + list + ' option'),
                hiddenInput = document.getElementById(input.getAttribute('id') + '-hidden'),
                label = input.value;

            hiddenInput.value = label;

            for(var i = 0; i < options.length; i++) {
                var option = options[i];

                if(option.innerText === label) {
                    hiddenInput.value = option.getAttribute('data-value');
                    break;
                }
            }
        });
    </script>
@endpush
