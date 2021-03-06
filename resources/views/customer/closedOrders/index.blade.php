@extends('customer.app')

@section('content')

    <div class="app-title">
        <div>
            <h1><i class="fa fa-briefcase"> </i> {{ __('Closed orders') }}</h1>
            <p>{{ __('Closed orders') }}</p>
        </div>

        <ul class="app-breadcrumb breadcrumb">
            <div class="dropdown ahref">
                <button class="btn btn-primary dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-lg fa-filter"></i> {{__('Filter')}}
                </button>

                <div class="dropdown-menu dropdown-menu-right filter mt-5 mt-md-0">
                    <form action="{{ route('customer.closedOrders.filter', app()->getLocale()) }}" method="get" role="form" class="px-4 py-3">


                        <div class="form-group">
                            <label for="status">{{ __('Status') }}</label>
                            <select class="form-control" id="status" name="status">
                                <option @if( ! empty($request->status)) value="{{$request->status}}"  @endif >{{--ak je nastaveny filter, tak sa nastavi value --}}
                                    @if( ! empty($request->status)){{--ak je nastaveny filter, tak sa vypise hodnota ako default na zoznam--}}
                                    {{__($statuses[$request->status-1]->nazov)}}
                                    @endif
                                </option>
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

                        <button type="submit" class="btn btn-primary">{{ __('Filter')}}</button>
                        <a id="drpClose" href="{{ route('customer.closedOrders.index' , app()->getLocale()) }}" class="btn btn-secondary">{{ __('Cancel')}}</a>

                    </form>
                </div>
            </div>
            <a href="{{ route('customer.export_excel.exportClosed', app()->getLocale()) }}" class="btn btn-primary ml-2 ml-md-2"> <i class="fa fa-fw fa-lg fa-file-excel-o"></i>{{ __('Excel') }}</a>

        </ul>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="tile">
                <div class="tile-body">
                </div>
                <div class="table-responsive">
                    <table data-order='[]' class="table table-hover table-bordered " id="sampleTable">
                        <thead>
                        <tr>
                            <th class="text-center">{{ __('Customer') }}</th>
                            <th class="text-center">{{ __('Order ID') }}</th>
                            <th class="text-center">{{ __('Order Name') }}</th>
                            <th class="text-center">{{ __('Total number of pieces') }}</th>
                            <th class="text-center">{{ __('Confirmation Date') }}</th>
                            <th class="text-center">{{ __('Expected date of completion') }}  </th>
                            <th class="text-center">{{ __('Status') }}  </th>
                            <th class="text-center">{{ __('Invoice') }}  </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($order as $row)
                            <tr>
                                <td>{{$row->user->name}}</td>
                                <td><a href="{{route('customer.openOrders.edit', ['id'=> $row->id,'locale'=>app()->getLocale()])}}"><strong>{{date("dmy",strtotime($row->dtm_vytvorenia)).$row->user->user_info->krajina.sprintf("%05s", $row->id)}}</strong></a></td>
                                <td>{{$row->nazov_objednavky}}</td>
                                <td>{{$row->pocet}}</td>
                                <td>{{date("d.m.Y",strtotime($row->dtm_vytvorenia))}}</td>
                                <td>{{date("d.m.Y",strtotime($row->dtm_ukoncenia))}}</td>
                                @if($row->status->nazov=="Dispatched")
                                    <td style="color: #cd1920"><strong>{{ __($row->status->nazov) }}</strong></td>
                                @elseif($row->status->nazov=="Invoiced")
                                    <td style="color: #0ba938"><strong>{{ __($row->status->nazov) }}</strong></td>
                                @endif
                                <td>{{$row->faktura}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{asset("/js/plugins/jquery.dataTables.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("/js/plugins/dataTables.bootstrap.min.js")}}"></script>
    @if(app()->getLocale()=="en")
        <script type="text/javascript">

            $('#sampleTable').DataTable( {
                "language": {
                    "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json"
                }
            } );
        </script>
    @endif
    @if(app()->getLocale()=="sk")
        <script type="text/javascript">

            $('#sampleTable').DataTable( {
                "language": {
                    "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Slovak.json"
                }
            } );
        </script>
    @endif
@endpush
