@extends('employee.app')

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-user"> </i> {{ __('Users') }} </h1>
            <p>{{ __('All users') }} </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">

                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th> {{ __('Company Name') }}</th>
                            <th> {{ __('Email') }} </th>
                            <th> {{ __('Contact Person') }} </th>
                            <th> {{ __('Origin') }} </th>
                            <th> {{ __('Tel. Number') }} </th>
                            <th> {{ __('User Type') }} </th>

                        </tr>
                        </thead>
                        <tbody>

                            @foreach($users as $row)
                                <tr>
                                    <td>{{$row->name }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{$row->user_info->meno }}</td>
                                    <td>{{ $row->user_info->krajina }}</td>
                                    <td>{{ $row->user_info->telefon }}</td>
                                    <td>{{ ucfirst(__($row->role))}}</td>
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
