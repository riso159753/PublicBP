@extends('admin.app')

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-user"> </i> {{ __('Users') }} </h1>
            <p>{{ __('All users') }} </p>
        </div>
        <a href="{{ route('admin.users.create', app()->getLocale()) }}" class="btn btn-primary pull-right">{{ __('Create User') }}</a>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ __($message) }}
                    </div>
                @endif
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ __($message) }}
                    </div>
                @endif
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th> {{ __('Company Name') }}</th>
                            <th> {{ __('Contact Person') }} </th>
                            <th> {{ __('Origin') }} </th>
                            <th> {{ __('Email') }} </th>
                            <th> {{ __('Tel. Number') }} </th>
                            <th> {{ __('User Type') }} </th>
                            <th class="text-center text-danger"><i class="fa fa-bolt"></i></th>
                        </tr>
                        </thead>
                        <tbody>

                            @foreach($users as $row)
                                <tr>
                                    <td>{{$row->name }}</td>
                                    <td>{{$row->user_info->meno }}</td>
                                    <td>{{ $row->user_info->krajina }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->user_info->telefon }}</td>
                                    <td>{{ ucfirst(__($row->role))}}</td>
                                    <td>
                                        <div class="btn-group d-flex justify-content-center" role="group" aria-label="First group">
                                           @if($row->deleted_at==null) <a href="{{ route('admin.users.delete', ['id'=>$row->id,'locale'=>app()->getLocale()]) }}" class="btn btn-sm btn-danger @if((app()->getLocale())=='en') delete-confirm @elseif((app()->getLocale())=='sk') delete-confirmSK @endif"><i class="fa fa-trash"></i></a>@endif
                                               @if($row->deleted_at!=null)<a href="{{ route('admin.users.activate', ['id'=>$row->id,'locale'=>app()->getLocale()]) }}" class="btn btn-sm btn-success @if((app()->getLocale())=='en') activate-confirm @elseif((app()->getLocale())=='sk') activate-confirmSK @endif"><i class="fa fa-power-off"></i></a>@endif
                                        </div>
                                    </td>
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
    <script type="text/javascript" src="{{asset("/js/sweetalert.min.js")}}"></script>

    <script>
        $('.delete-confirm').on('click', function (e) {
            event.preventDefault();
            const url = $(this).attr('href');
            swal({
                title: 'Are you sure?',
                text: 'This user will be deactivated!',
                icon: 'error',
                buttons: ["Cancel", "Yes, deactivate!"],
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
                text: 'Používateľ bude deaktivovaný!',
                icon: 'error',
                buttons: ["Zrušiť", "Potvrdiť deaktivovanie"],
            }).then(function(value) {
                if (value) {
                    window.location.href = url;

                }
            });
        });</script>
        @endpush
