@extends('employee.app')

@section('content')

    <div class="app-title">
        <div>

            <h1><i class="fa fa-briefcase"></i> {{ __('Edit order') }}</h1>
            <p> {{ __('Edit order') }}</p>
        </div>
        <a href="{{ route('employee.openOrders.index', app()->getLocale()) }}" class="btn btn-primary pull-right">{{ __('Orders') }}</a>

    </div>
    <div class="col-md-12">
        <form action="{{ route('employee.openOrders.update', ['id'=> $order->id,'locale'=>app()->getLocale()]) }}" method="POST" role="form">
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
                                {{  __($message) }}
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
                                        <label class="control-label" for="customer">{{ __('Customer') }}</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            placeholder="{{ __('Enter customer name') }}"
                                            id="customer"
                                            name="customer"
                                            value="{{ old('customer',$order->user->name) }}"
                                            readonly
                                        />
                                    </div>
                                </div>
                                <input type="hidden" name="pouzivatel_id" value="{{$order->pouzivatel_id}}">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="orderName">{{ __('Name of order') }} *</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            placeholder="{{ __('Enter name of order') }}"
                                            id="orderName"
                                            name="orderName"
                                            value="{{ old('orderName', $order->nazov_objednavky) }}"
                                            required
                                            @if($order->status_id>6)readonly @endif
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="items">{{ __('List of Items') }} *</label>
                                <textarea name="items" id="items" rows="6" class="form-control" maxlength="300" required  @if($order->status_id>6)readonly @endif>{{$order->polozky}}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="description">{{ __('Description') }}</label>
                                        <textarea name="description" id="description" rows="6" maxlength="300" class="form-control"  @if($order->status_id>6)readonly @endif>{{$order->popis}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="note">{{ __('Note') }}</label>
                                        <textarea name="note" id="note" rows="6" class="form-control" maxlength="500" @if($order->status_id>6)readonly @endif>{{$order->poznamka}}</textarea>
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
                                            value="{{ old('quantity',$order->pocet) }}"
                                            min="1"
                                            required
                                            @if($order->status_id>6)readonly @endif
                                        />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleSelect1">{{ __('Status') }}</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="{{$order->status_id}}">{{ __($order->status->nazov) }}</option>
                                            {{$i=1}}
                                            @foreach($status as $statuses)
                                                <option value="{{$i++}}">{{ __($statuses->nazov) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="quantity">{{ __('Date of confirmation') }}</label>
                                        <input
                                            class="form-control"
                                            type="date"
                                            id="confirmationDate"
                                            name="confirmationDate"
                                            value="{{ old('confirmationDate',$order->dtm_vytvorenia) }}"
                                            readonly
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
                                            value="{{ old('completionDate',$order->dtm_ukoncenia) }}"
                                            required
                                            @if($order->status_id>6)readonly @endif
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="quantity">{{ __('Tracking number') }}</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            id="trackingNumber"
                                            name="trackingNumber"
                                            value="{{ old('confirmationDate',$order->tracking_num) }}"
                                            autocomplete="off"
                                        />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="orderName">{{ __('Invoice') }}</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            id="invoice"
                                            name="invoice"
                                            value="{{ old('completionDate',$order->faktura) }}"
                                            autocomplete="off"
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
                                        <table class="table table-bordered  " id="dynamic_field">
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
                                                <th style="width: 6%">{{ __('Size') }}</th>
                                                <th style="width: 7%">{{ __('Number') }}</th>
                                                @if($order->status_id<7)<th><button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-fw fa-lg fa-plus"></i></button></th>@endif
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($items as $row)
                                                <tr>
                                                    <td><input type="text" name="product[]" class="form-control" value="{{$row->product}}"  @if($order->status_id>6) readonly @endif></td>
                                                    <td><input type="text" name="person[]" class="form-control" value="{{$row->person}}" @if($order->status_id>6) readonly @endif></td>
                                                    <td><select  class="form-control"  id="material" name="material[]"  @if($order->status_id>6) readonly @endif>
                                                            @if($row->material)  <option  value="{{$row->material}}">{{ __($row->materials->name) }}</option>@endif
                                                            @if($order->status_id<7)
                                                                <option value=""></option>
                                                                @foreach($materialsAll as $material)
                                                                    <option value="{{$material->id}}">{{$material->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td><input type="hidden" name="trim[{{$loop->index}}]" value="0"><input type="checkbox" name="trim[{{$loop->index}}]" class="form-control" value="1" @if($row->trim==1)checked @endif @if($order->status_id>6) onclick="this.checked=!this.checked;" @endif> </td>
                                                    <td><select name="sidePanel[]" class="form-control" id="sidePanel" @if($order->status_id>6) readonly @endif>
                                                            @if($row->sidePanel)<option  value="{{$row->sidePanel}}">{{ __($materialsAll[$row->sidePanel-1]->name) }}</option>@endif
                                                            @if($order->status_id<7)
                                                                <option value=""></option>
                                                                @foreach($materialsAll as $material)
                                                                    <option value="{{$material->id}}">{{$material->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td><input type="hidden" name="panel[{{$loop->index}}]" value="0"><input type="checkbox" name="panel[{{$loop->index}}]" class="form-control" value="1" @if($row->panel==1)checked @endif @if($order->status_id>6) onclick="this.checked=!this.checked;" @endif></td>
                                                    <td><input type="hidden" name="zip[{{$loop->index}}]" value="0"><input type="checkbox" name="zip[{{$loop->index}}]" class="form-control" value="1" @if($row->zip==1) checked @endif @if($order->status_id>6) onclick="this.checked=!this.checked;" @endif></td>
                                                    <td>
                                                        <select name="collar[]" class="form-control" @if($order->status_id>6) readonly @endif>
                                                            @if($row->collar)<option  value="{{$row->collar}}">{{ __($materialsAll[$row->collar-1]->name) }}</option>@endif
                                                            @if($order->status_id<7)
                                                                <option value=""></option>
                                                                @foreach($materialsAll as $material)
                                                                    <option value="{{$material->id}}">{{$material->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="size[]" class="form-control" value="{{$row->size}}" @if($order->status_id>6) readonly @endif></td>
                                                    <td><input type="number" name="number[]" class="form-control" value="{{$row->number}}" required @if($order->status_id>6) readonly @endif></td>
                                                    @if($order->status_id<7)<td><button type="button" name="remove" data-target="#delete" data-title="Delete" id="'+i+'"  class="btn  btn-danger   @if((app()->getLocale())=='en') delete-confirm @elseif((app()->getLocale())=='sk') delete-confirmSK @endif"><i class="fa fa-fw fa-lg fa-remove"></i></button></td>@endif
                                                    <input type="hidden" name="idItem[]" value="{{$row->id}}">

                                                </tr>

                                            @endforeach
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
                                        <button class="btn btn-success @if((app()->getLocale())=='en') save-confirm @elseif((app()->getLocale())=='sk') save-confirmSK @endif" type="submit"><i class="fa fa-fw fa-lg fa-check-circle "></i>{{ __('Save Product') }}</button>
                                        <a class="btn btn-danger" @if($order->status_id<7) href="{{ route('employee.openOrders.index', app()->getLocale()) }}" @else href="{{route('employee.closedOrders.index', app()->getLocale())}}" @endif><i class="fa fa-fw fa-lg fa-arrow-left"></i>{{ __('Go Back') }}</a>
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

                var i=1;


                $('#add').click(function(){
                    i++;
                    $('#dynamic_field').append('<tr id="row'+i+'"  style="display: table-row">' +

                        '    <td><input type="text" name="product[]" class="form-control" /></td>\n' +
                        '    <td><input type="text" name="person[]" class="form-control" />\n' +
                        '    <td><select class="form-control " id="material" name="material[]" >\n' +
                        '             <option ></option>\n'+
                        {!! json_encode(App\Http\Controllers\Employee\HomeControllerEmployee::generateOptionList()); !!}+
                            '             </select>\n'+
                        '    <td><input type="checkbox" name="trim[]" class="form-control" value="1"><input type="hidden" name="trim[]" value="0"></td>\n' +
                        '    <td><select class="form-control " id="sidePanel" name="sidePanel[]" >\n' +
                        '             <option ></option>\n'+
                        {!! json_encode(App\Http\Controllers\Employee\HomeControllerEmployee::generateOptionList()); !!}+
                            '             </select>\n'+
                        '    <td><input type="checkbox" name="panel[]" class="form-control" value="1"><input type="hidden" name="panel[]" value="0"></td>\n' +
                        '    <td><input type="checkbox" name="zip[]" class="form-control" value="1"><input type="hidden" name="zip[]" value="0"></td>\n' +
                        '    <td><select class="form-control " id="collar" name="collar[]" >\n' +
                        '             <option ></option>\n'+
                        {!! json_encode(App\Http\Controllers\Employee\HomeControllerEmployee::generateOptionList()); !!}+
                            '             </select>\n'+
                        '    <td><input type="text" name="size[]" class="form-control" /></td>' +
                        '    <td><input type="number" name="number[]" class="form-control" required /></td>\n' +
                        '    <td><button type="button" name="remove" id="'+i+'"  class="btn btn_remove btn-danger remove"><i class="fa fa-fw fa-lg fa-remove"></i></button></td></tr>');
                });

                $(document).on('click', '.btn_remove', function(){
                    var button_id = $(this).attr("id");
                    $('#row'+button_id+'').remove();
                });


                $(".remove-officer-button").on('click', function (e) {

                    if (confirm('Are you sure you want to delete this?')) {
                        var whichtr = $(this).closest("tr");
                        whichtr.remove();
                    }


                });



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
                    whichtr = $(this).closest("tr");
                    swal({
                        title: 'Are you sure?',
                        text: 'This record will be permanantly deleted!',
                        icon: 'error',
                        buttons: ["Cancel", "Yes!"],
                    }).then(function () {
                        whichtr.remove();
                        //swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        // window.location.href = url;

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
                        text: 'Záznam bude odstránený zo systému!',
                        icon: 'error',
                        buttons: ["Zrušiť", "Potvrdiť vymazanie"],
                    }).then(function() {

                        whichtr.remove();

                    });
                });</script>

            <script>
                $('.save-confirm').on('click', function (e) {
                    var $form =  $(this).closest("form"); //Get the form here
                    e.preventDefault();
                    const url = $(this).attr('href');

                    swal({
                        title: 'Are you sure?',
                        text: 'This record will be saved!',
                        icon: 'info',
                        buttons: ["Cancel", "Yes!"],
                    }).then((Save) => {
                        if (Save) {
                            $form.submit(); //Submit your Form Here.
                            //$('#yourFormId').submit(); //Use same Form Id to submit the Form.
                        }
                    });
                });</script>
            <script>
                $('.save-confirmSK').on('click', function (e) {
                    var $form =  $(this).closest("form"); //Get the form here
                    e.preventDefault();
                    const url = $(this).attr('href');

                    swal({
                        title: 'Ste si naozaj istý?',
                        text: 'Záznam bude upravený!',
                        icon: 'info',
                        buttons: ["Zrušiť", "Ano!"],
                    }).then((Save) => {
                        if (Save) {
                            $form.submit(); //Submit your Form Here.
                            //$('#yourFormId').submit(); //Use same Form Id to submit the Form.
                        }
                    });
                });</script>


    @endpush


