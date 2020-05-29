@extends('admin.app')

@section('content')

    <div class="app-title">
        <div>
            <h1><i class="fa fa-briefcase"> </i> {{ __('Open Orders') }}</h1>
            <p>{{ __('Open Orders') }}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <div class="dropdown ahref">
                <button class="btn btn-primary dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-lg fa-filter"></i> {{__('Filter')}}
                </button>

                <div class="dropdown-menu dropdown-menu-right filter mt-5 mt-md-0">
                    <form action="{{ route('admin.openOrders.filter', app()->getLocale()) }}" method="get" role="form" class="px-4 py-3">

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
                        <a id="drpClose" href="{{ route('admin.openOrders.index' , app()->getLocale()) }}" class="btn btn-secondary">{{ __('Cancel')}}</a>

                    </form>
                </div>
            </div>
            <a href="{{ route('admin.export_excel.exportActives', app()->getLocale()) }}" class="btn btn-primary ml-2 ml-md-2"> <i class="fa fa-fw fa-lg fa-file-excel-o"></i>{{ __('Excel') }}</a>

            <a href="{{ route('admin.openOrders.create', app()->getLocale()) }}" class="btn btn-primary ml-2 ml-md-2"> <i class="fa fa-fw fa-lg fa-plus"></i>{{ __('Add Order') }}</a>
        </ul>


    </div>

    <div class="row ">
        <div class="col-md-12 col-sm-12">
            <div class="tile">
                <div class="tile-body">
                </div>
                <div class="table-responsive">
                    <form action="{{ route('admin.openOrders.select', app()->getLocale()) }}" method="POST" role="form">
                        @csrf
                        <div class="container-fluid">
                            <table data-order='[]' class="table table-hover w-100 table-bordered " id="sampleTable">
                                <thead>
                                <tr>
                                    <th class="no-sort text-center"> <button class="btn btn-sm btn-primary" type="submit"><span class="d-none d-md-block"><i class="fa fa-edit"></i>{{__('Change')}}</span><span class="d-md-none"><i class="fa fa-edit"></i></span></button></th>
                                    <th class="text-center">{{ __('Order ID') }}</th>
                                    <th class="text-center">{{ __('Customer') }}</th>
                                    <th class="text-center">{{ __('Order Name') }}</th>
                                    <th class="text-center">{{ __('Total number of pieces') }}</th>
                                    <th class="text-center">{{ __('Confirmation Date') }}</th>
                                    <th class="text-center">{{ __('Expected date of completion')}}  </th>
                                    <th class="text-center">{{ __('Status') }}  </th>
                                    <th class="text-center text-danger"><i class="fa fa-bolt"></i></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($order as $row)
                                    <tr>
                                        <td>
                                            <div class="animated-checkbox text-center">
                                                <label>
                                                    <input type="checkbox" name="CkdOrders[]" value="{{$row->id}}"><span class="label-text"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td><a href="{{route('admin.openOrders.edit', ['id'=> $row->id,'locale'=>app()->getLocale()]) }}"><strong>{{date("dmy",strtotime($row->dtm_vytvorenia)).$row->user->user_info->krajina.sprintf("%05s", $row->id)}}</strong></a></td>
                                        <td>{{$row->user->name}}</td>
                                        <td>{{$row->nazov_objednavky}}</td>
                                        <td>{{$row->pocet}}</td>
                                        <td>{{date("d.m.Y",strtotime($row->dtm_vytvorenia))}}</td>
                                        <td>{{date("d.m.Y",strtotime($row->dtm_ukoncenia))}}</td>
                                        @if($row->status->nazov=="Order Confirmed")
                                            <td style="color: black"><strong>{{ __($row->status->nazov) }}</strong></td>
                                        @elseif($row->status->nazov=="Production model")
                                            <td style="color: #00eded"><strong>{{ __($row->status->nazov) }}</strong></td>
                                        @elseif($row->status->nazov=="Preparation")
                                            <td style="color: orange"><strong>{{ __($row->status->nazov) }}</strong></td>
                                        @elseif($row->status->nazov=="Export to Press")
                                            <td style="color: saddlebrown"><strong>{{ __($row->status->nazov) }}</strong></td>
                                        @elseif($row->status->nazov=="Press")
                                            <td style="color: #ff67a4;"><strong>{{ __($row->status->nazov) }}</strong></td>
                                        @else
                                            <td style="color:#0070c0;"><strong>{{ __($row->status->nazov) }}</strong></td>
                                        @endif
                                        <td>
                                            <div class="btn-group d-flex justify-content-center" role="group" aria-label="First group">

                                                <a href="{{route('admin.openOrders.nextStatus', ['id'=> $row->id,'locale'=>app()->getLocale()]) }}" class="btn btn-sm btn-info "><i class="fa fa-level-up"></i></a>
                                                <a href="{{route('admin.openOrders.edit', ['id'=> $row->id,'locale'=>app()->getLocale()]) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('admin.openOrders.delete', ['id'=>$row->id,'locale'=>app()->getLocale()]) }}" class="btn btn-sm btn-danger @if((app()->getLocale())=='en') delete-confirm @elseif((app()->getLocale())=='sk') delete-confirmSK @endif"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
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
    <script type="text/javascript" src="{{asset("/js/sweetalert.min.js")}}"></script>
    <script>
        $(function() {
            $('.nextStatus').change(function() {
                var user_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/changeStatus',
                    data: {'status': status, 'user_id': user_id},
                    success: function(data){
                        console.log(data.success)
                    }
                });
            })
        })
    </script>
    <script>
        $('.delete-confirm').on('click', function (e) {
            event.preventDefault();
            const url = $(this).attr('href');
            swal({
                title: 'Are you sure?',
                text: 'This record will be permanantly deleted!',
                icon: 'error',
                buttons: ["Cancel", "Yes!"],
            }).then(function (value) {
                if (value) {
                    window.location.href = url;
                }
            });
        })
    </script>
    <script>
        $('.delete-confirmSK').on('click', function (e) {
            event.preventDefault();
            const url = $(this).attr('href');
            swal({
                title: 'Ste si naozaj istý?',
                text: 'Záznam bude odstránený zo systému!',
                icon: 'error',
                buttons: ["Zrušiť", "Potvrdiť vymazanie"],
            }).then(function(value) {
                if (value) {
                    window.location.href = url;
                }
            });
        });</script>


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
