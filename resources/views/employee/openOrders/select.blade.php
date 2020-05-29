@extends('employee.app')

@section('content')

    <div class="app-title">
        <div>
            <h1><i class="fa fa-briefcase"> </i> {{ __('Open Orders') }}</h1>
            <p>{{ __('Open Orders') }}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <div class="dropdown ahref">



            </div>

            <a href="{{ route('employee.openOrders.create', app()->getLocale()) }}" class="btn btn-primary ml-2 ml-md-2"> <i class="fa fa-fw fa-lg fa-plus"></i>{{ __('Add Order') }}</a>
        </ul>


    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="tile">
                <div>
                    <h2 class="text-center">{{__('Bulk change')}}</h2><br>
                </div>

                <form action="{{ route('employee.openOrders.updateSelection', app()->getLocale()) }}" method="POST" role="form">
                    @csrf
                    <div >
                        <div class="row justify-content-center">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleSelect1">{{ __('Status') }}</label>
                                    <select class="form-control" id="status" name="status">
                                        <option></option>
                                        {{$i=1}}
                                        @foreach($statuses as $status)
                                            <option value="{{$i++}}">{{ __($status->nazov) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">{{ __('Date of completion') }}</label>
                                    <input class="form-control" type="date" name="completionDate">
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="tile-footer">
                        <div class="d-flex">
                            <div class="p-2 ml-auto">
                                <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>{{ __('Save changes') }}</button>
                            </div>
                            <div class="p-2">
                                <a class="btn btn-danger" href="javascript:history.back()"><i class="fa fa-fw fa-lg fa-arrow-left"></i>{{ __('Go Back') }}</a>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
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

                                <td><a href="{{route('employee.openOrders.edit', ['id'=> $row->id,'locale'=>app()->getLocale()]) }}"><strong>{{date("dmy",strtotime($row->dtm_vytvorenia)).$row->user->user_info->krajina.sprintf("%05s", $row->id)}}</strong></a></td>
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

                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script type="text/javascript" src="{{asset("/js/plugins/jquery.dataTables.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("/js/plugins/dataTables.bootstrap.min.js")}}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>

    <script type="text/javascript" src="{{asset("/js/sweetalert.min.js")}}"></script>
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
