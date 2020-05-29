@extends('employee.app')

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-industry"> </i> {{ __('Materials') }} </h1>
            <p>{{ __('Materials') }} </p>
        </div>
        <div class="dropdown ahref">
            <button class="btn btn-primary dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-fw fa-lg fa-plus"></i> {{__('New material')}}
            </button>
            <div class="dropdown-menu dropdown-menu-right filter mt-5 mt-md-0">
                <form action="{{ route('employee.materials.save', app()->getLocale()) }}" method="post" role="form" class="px-4 py-3">
                    @csrf
                    <div class="form-group">
                        <label for="customer">{{ __('Material name') }}</label>
                        <input class="form-control" name="name" id="name" required autocomplete="off" >

                    </div>

                    <div class="dropdown-divider"></div>

                    <button type="submit" class="btn btn-primary">{{ __('Add material')}}</button>
                    <a id="drpClose" data-toggle="dropdown" href="#" class="btn btn-secondary">{{ __('Cancel')}}</a>
                </form>
            </div>
        </div>
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
                        {{ $message }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-dismissable alert-danger">
                        @if (!isset($only_errors) || !$only_errors)
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                        @endif
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ __($error) }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th> {{ __('Name') }}</th>
                            <th> {{ __('Delete') }} </th>
                        </tr>
                        </thead>
                        <tbody>


                        @foreach($materials as $row)
                            <tr>
                                <td>{{$row->name }}</td>
                                <td>
                                    <div class="btn-group d-flex justify-content-end" role="group" aria-label="First group">
                                        <a href="{{ route('employee.materials.deleteEmployee', ['id'=>$row->id,'locale'=>app()->getLocale()]) }}" class="btn btn-sm btn-danger @if((app()->getLocale())=='en') delete-confirm @elseif((app()->getLocale())=='sk') delete-confirmSK @endif"><i class="fa fa-trash"></i></a>
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
            whichtr = $(this).closest("tr");
            swal({
                title: 'Are you sure?',
                text: 'This material will be deleted!',
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
            whichtr = $(this).closest("tr");

            swal({
                title: 'Ste si naozaj istý?',
                text: 'Tento materiál bude vymazaný!',
                icon: 'error',
                buttons: ["Zrušiť", "Áno!"],
            }).then(function (value) {
                if (value) {
                    window.location.href = url;
                }
            });
        });</script>
@endpush
