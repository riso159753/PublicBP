@extends('employee.app')

@section('content')

    <div class="app-title">
        <div>
            <h1><i class="fa fa-briefcase"> </i> {{ __('Settings') }}</h1>
            <p>{{ __('Account') }} - {{$user['meno']}}</p>
        </div>
    </div>

    <div class="row d-flex justify-content-center ">
        <div class="col-md-5 col-sm-5">
            <div class="tile">
                <form action="{{ route('employee.settings.updateInfoEmployee', app()->getLocale()) }}" method="POST" role="form">
                    @csrf
                    <h5 class="">{{ __('Personal information') }}</h5>
                    <hr>
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-12  h-100">
                                <div class="form-group row">
                                    <label class="control-label col-md-4 my-auto" for="customer">{{ __('Name') }} *</label>
                                    <div class="col-md-8">
                                        <input
                                            class="form-control"
                                            type="text"
                                            id="name"
                                            name="name"
                                            value="{{$user['meno']}}"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12  h-100">
                                <div class="form-group row">
                                    <label class="control-label col-md-4 my-auto" for="customer">{{ __('Tel. number') }} *</label>
                                    <div class="col-md-8">
                                        <input
                                            class="form-control"
                                            type="text"
                                            id="telefon"
                                            name="telefon"
                                            value="{{$user['telefon']}}"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <div class="row d-print-none mt-2">
                                <div class="col-12 text-right">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>{{ __('Save') }}</button>
                                    <a class="btn btn-danger" href="{{ route('employee.settings.index', app()->getLocale()) }}"><i class="fa fa-times-circle"></i>{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>
        <div class="col-md-5 col-sm-5">
            <div class="tile">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{  __($message) }}
                    </div>
                @endif

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ __($message) }}
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
                <form action="{{ route('employee.settings.updatePassEmployee', app()->getLocale()) }}" method="POST" role="form">
                    @csrf
                    <h5 class="">{{ __('Change password') }}</h5>
                    <hr>
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-12  h-100">
                                <div class="form-group row">
                                    <label class="control-label col-md-4 my-auto" for="customer">{{ __('Old password') }} *</label>
                                    <div class="col-md-8">
                                        <input
                                            class="form-control"
                                            type="password"
                                            id="oldPass"
                                            name="oldPass"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12  h-100">
                                <div class="form-group row">
                                    <label class="control-label col-md-4 my-auto" for="customer">{{ __('New password') }} *</label>
                                    <div class="col-md-8">
                                        <input
                                            class="form-control"
                                            type="password"
                                            id="password"
                                            name="password"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12  h-100">
                                <div class="form-group row">
                                    <label class="control-label col-md-4 my-auto" for="customer">{{ __('Confirm password') }} *</label>
                                    <div class="col-md-8">
                                        <input
                                            class="form-control"
                                            type="password"
                                            id="password_confirmation"
                                            name="password_confirmation"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <div class="row d-print-none mt-2">
                                <div class="col-12 text-right">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>{{ __('Save') }}</button>
                                    <a class="btn btn-danger" href="{{ route('employee.settings.index', app()->getLocale()) }}"><i class="fa fa-times-circle"></i>{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{asset("/js/plugins/jquery.dataTables.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("/js/plugins/dataTables.bootstrap.min.js")}}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush
