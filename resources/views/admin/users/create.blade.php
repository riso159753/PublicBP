@extends('admin.app')

@section('content')

    <div class="app-title">
        <div>

            <h1><i class="fa fa-user"></i> {{ __('Users') }}</h1>
            <p>{{ __('Create User') }}</p>
        </div>
        <a href="{{ route('admin.users.index', app()->getLocale()) }}" class="btn btn-primary pull-right">{{ __('Users') }}</a>
    </div>

    <div class="col-md-12">
        <div class="tab-content">
            <div class="tab-pane active" id="general">
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

                    @if ($message = Session::get('warning'))
                        <div class="alert alert-warning alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ __($message) }}
                        </div>
                    @endif

                    @if ($message = Session::get('info'))
                        <div class="alert alert-info alert-block">
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
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.save', app()->getLocale()) }}" method="POST" role="form">
                        @csrf
                        <h3 class="tile-title">{{ __('User information') }}</h3>
                        <hr>
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="customer">{{ __('Customer') }} *</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            placeholder="{{ __('Enter customer name') }}"
                                            id="customer"
                                            name="customer"
                                            value="{{ old('customer') }}"
                                        />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="email">{{ __('Email') }} *</label>
                                        <input
                                            class="form-control"
                                            type="email"
                                            placeholder="{{ __('Enter email') }}"
                                            id="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                        />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="email">{{ __('Contact Person') }}</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            placeholder="{{ __('Enter contact person') }}"
                                            id="contact"
                                            name="contact"
                                            value="{{ old('contact') }}"
                                        />
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="mobile">{{ __('Telephone number') }}</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            placeholder="{{ __('Enter telephone number') }}"
                                            id="mobile"
                                            name="mobile"
                                            value="{{ old('mobile') }}"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="note">{{ __('Role') }} *</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="role" value="admin">{{ __('Administrator') }}
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="role" value="employee" >{{ __('Employee') }}
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="role" value="customer">{{ __('Customer') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="note">{{ __('Customer origin') }}</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="origin" value="EU">EU
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="origin" value="CZ" checked>CZ
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="tile-footer">
                            <div class="row d-print-none mt-2">
                                <div class="col-12 text-right">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>{{ __('Save Product') }}</button>
                                    <a class="btn btn-danger" href="{{ route('admin.users.index', app()->getLocale()) }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>{{ __('Go Back') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--    @push('scripts')--}}
{{--        <script type="text/javascript" src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>--}}
{{--        <script type="text/javascript" src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>--}}
{{--        <script type="text/javascript">$('#sampleTable').DataTable();</script>--}}
{{--    @endpush--}}


