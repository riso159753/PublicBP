@extends('employee.app')

@section('content')

    <div class="app-title">
        <div>

            <h1><i class="fa fa-briefcase"></i> {{ __('Add order') }}</h1>
            <p>{{ __('Add order') }}</p>
        </div>
        <a href="{{ route('employee.openOrders.index', app()->getLocale()) }}" class="btn btn-primary pull-right">{{ __('Orders') }}</a>
    </div>

    <div class="col-md-12">
        <form action="{{ route('employee.openOrders.save', app()->getLocale()) }}" method="POST" role="form">
            @csrf
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
                                {{ $message }}
                            </div>
                        @endif

                        @if ($message = Session::get('warning'))
                            <div class="alert alert-warning alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ $message }}
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


                        <h3 class="tile-title">{{ __('Order Information') }}</h3>
                        <hr>
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="customer">{{ __('Customer') }} *</label>
                                        <select class="form-control selectpicker" data-live-search="true" id="customer" name="customer" required>
                                            <option></option>
                                            @foreach($users as $user)
                                                <option value="{{$user->email}}">{{$user->name}} - {{$user->email}}</option>
                                            @endforeach
                                        </select>
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
                                            value="{{ old('orderName') }}"
                                            autocomplete="off"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="items">{{ __('List of Items') }} *</label>
                                <textarea name="items" id="items" rows="6" class="form-control" maxlength="300" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="description">{{ __('Description') }}</label>
                                        <textarea name="description" id="description" rows="6" maxlength="300" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="note">{{ __('Note') }}</label>
                                        <textarea name="note" id="note" rows="6" maxlength="500" class="form-control"></textarea>
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
                                            value="{{ old('quantity') }}"
                                            min="1"
                                            required
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
                                            value="{{ old('completionDate') }}"
                                            required
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
                                        <table class="table table-bordered " id="dynamic_field">
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
                                                <th >{{ __('Size') }}</th>
                                                <th >{{ __('Number') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><input type="text" name="product[]" class="form-control" /></td>


                                                <td><input type="text" name="person[]" class="form-control" /></td>
                                                <td><select class="form-control"  id="material" name="material[]" >
                                                        <option ></option>
                                                        @foreach($materials as $material)
                                                            <option value="{{$material->id}}">{{$material->name}}</option>
                                                        @endforeach
                                                    </select></td>
                                                <td><input type="checkbox" name="trim[]" class="form-control" value="1"/><input type="hidden" name="trim[]" value="0"></td>
                                                <td><select class="form-control"   id="sidePanel" name="sidePanel[]">
                                                        <option ></option>
                                                        @foreach($materials as $material)
                                                            <option value="{{$material->id}}">{{$material->name}}</option>
                                                        @endforeach
                                                    </select></td>
                                                <td><input type="checkbox" name="panel[]" class="form-control" value="1"/><input type="hidden" name="panel[]" value="0"></td>
                                                <td><input type="checkbox" name="zip[]" class="form-control" value="1"/><input type="hidden" name="zip[]" value="0"></td>
                                                <td><select class="form-control"   id="collar" name="collar[]" >
                                                        <option ></option>
                                                        @foreach($materials as $material)
                                                            <option value="{{$material->id}}">{{$material->name}}</option>
                                                        @endforeach
                                                    </select></td>
                                                <td><input type="text" name="size[]" class="form-control" /></td>
                                                <td><input type="text" name="number[]" class="form-control" required /></td>
                                                <td><button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-fw fa-lg fa-plus"></i></button></td>
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
                                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>{{ __('Save Product') }}</button>
                                        <a class="btn btn-danger" href="{{ route('employee.openOrders.index', app()->getLocale()) }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>{{ __('Go Back') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </form>
        @endsection

        @push('scripts')


            <script>
                $("#more").css("overflow","visible");
                var i=1;


                $('#add').click(function(){
                    var materials = {!! $materials !!}
                        i++;
                    $('#dynamic_field').append('<tr id="row'+i+'"  style="display: table-row">' +

                        '    <td><input type="text" name="product[]" class="form-control" /></td>\n' +
                        '    <td><input type="text" name="person[]" class="form-control" />\n' +
                        '    <td><select class="form-control " id="material" name="material[]" >\n' +
                        '             <option ></option>\n'+
                        {!! json_encode(App\Http\Controllers\Employee\HomeControllerEmployee::generateOptionList()); !!}+
                            '             </select>\n'+
                        '    <td><input type="checkbox" name="trim[]" class="form-control" value="1"/><input type="hidden" name="trim[]" value="0"></td>\n' +
                        '    <td><select class="form-control " id="sidePanel" name="sidePanel[]" >\n' +
                        '             <option ></option>\n'+
                        {!! json_encode(App\Http\Controllers\Employee\HomeControllerEmployee::generateOptionList()); !!}+
                            '             </select>\n'+
                        '    <td><input type="checkbox" name="panel[]" class="form-control" value="1"/><input type="hidden" name="panel[]" value="0"></td>\n' +
                        '    <td><input type="checkbox" name="zip[]" class="form-control" value="1"/><input type="hidden" name="zip[]" value="0"></td>\n' +
                        '    <td><select class="form-control " id="collar" name="collar[]" >\n' +
                        '             <option ></option>\n'+
                        {!! json_encode(App\Http\Controllers\Employee\HomeControllerEmployee::generateOptionList()); !!}+
                            '             </select>\n'+
                        '    <td><input type="text" name="size[]" class="form-control" /></td>' +
                        '    <td><input type="text" name="number[]" class="form-control" required /></td>\n' +
                        '    <td><button type="button" name="remove" id="'+i+'"  class="btn btn_remove btn-danger remove"><i class="fa fa-fw fa-lg fa-remove"></i></button></td></tr>');
                });


                $(document).on('click', '.btn_remove', function(){
                    var button_id = $(this).attr("id");
                    $('#row'+button_id+'').remove();
                });


            </script>

    @endpush


