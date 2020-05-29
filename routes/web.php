<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::get('/pass/{token}', 'Auth\CreatePass@index')->name('createPass.index');

Route::get('/',function ()
{
    return redirect(app()->getLocale());
});
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/getEmployees', 'AutocompleteController@getEmployees')->name('autocomplete.getEmployees');


Route::group([
    'prefix'=>'{locale}',
    'where' =>['locale'=>'[a-zA-Z]{2}'],
    'middleware'=>['setlocale'],
    ],function () {
    Route::get('/', function () {
        return view('welcome');
    });


    Route::POST('/password/login', 'Auth\LoginController@login');
    Route::get('/password/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::POST('/password/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/password/logout', 'Auth\LoginController@logout')->name('logout');


    Route::get('/password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::POST('/password/confirm', 'Auth\ConfirmPasswordController@confirm');
    Route::POST('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::POST('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::POST('/register', 'Auth\RegisterController@register');
    Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');


    Route::POST('/pass/{token}', 'Auth\CreatePass@save')->name('createPass.save');

    //Admin
    Route::group(['middleware'=>['admin','active_user']], function () {
        Route::group(['namespace' => 'Admin', 'prefix' => 'orders'], function () {
            Route::get('/', 'HomeController@index')->name('admin.openOrders.index');
            Route::get('/filter', 'HomeController@filter')->name('admin.openOrders.filter');
            Route::get('/create', 'HomeController@create')->name('admin.openOrders.create');
            Route::get('/save', 'HomeController@save')->name('admin.openOrders.save');
            Route::POST('/save', 'HomeController@save')->name('admin.openOrders.save');
            Route::get('/edit/{id}', 'HomeController@edit')->name('admin.openOrders.edit');
            Route::POST('/update', 'HomeController@update')->name('admin.openOrders.update');
            Route::get('/delete/{id}', 'HomeController@delete')->name('admin.openOrders.delete');
            Route::POST('/select', 'HomeController@select')->name('admin.openOrders.select');
            Route::get('/select', 'HomeController@select')->name('admin.openOrders.select');
            Route::POST('/updateSelection', 'HomeController@updateSelection')->name('admin.openOrders.updateSelection');
            Route::get('/nextStatus/{id}', 'HomeController@nextStatus')->name('admin.openOrders.nextStatus');
            Route::get('/export_actives', 'HomeController@exportActives')->name('admin.export_excel.exportActives');
            Route::get('/ajax_delete/{item}', 'HomeController@ajaxDelete')->name('admin.item.delete');
        });

        Route::group(['namespace' => 'Admin', 'prefix' => 'settings'], function () {
            Route::get('/', 'SettingsController@index')->name('admin.settings.index');
            Route::POST('/updatePass', 'SettingsController@updatePass')->name('admin.settings.updatePass');
            Route::POST('/updateInfo', 'SettingsController@updateInfo')->name('admin.settings.updateInfo');


        });

        Route::group(['namespace' => 'Admin', 'prefix' => 'materials'], function () {
            Route::get('/', 'MaterialsController@index')->name('admin.materials.index');
            Route::POST('/save', 'MaterialsController@save')->name('admin.materials.save');
            Route::get('/delete/{id}', 'MaterialsController@delete')->name('admin.materials.delete');


        });

        Route::group(['namespace' => 'Admin', 'prefix' => 'co'], function () {
            Route::get('/orders', 'ClosedOrdersController@index')->name('admin.closedOrders.index');
            Route::get('/edit/{id}', 'HomeController@edit')->name('admin.closedOrders.edit');
            Route::post('/update', 'HomeController@update')->name('admin.closedOrders.update');
            Route::get('/filter', 'ClosedOrdersController@filter')->name('admin.closedOrders.filter');
            Route::get('/export_closed', 'ClosedOrdersController@exportClosed')->name('admin.export_excel.exportClosed');

        });

        Route::group(['namespace' => 'Admin', 'prefix' => 'users'], function () {
            Route::get('/users', 'UserController@index')->name('admin.users.index');
            Route::get('/create', 'UserController@create')->name('admin.users.create');
            Route::get('/save', 'UserController@save')->name('admin.users.save');
            Route::POST('/save', 'UserController@save')->name('admin.users.save');
            Route::get('/delete/{id}', 'UserController@delete')->name('admin.users.delete');
            Route::get('/activate/{id}', 'UserController@activate')->name('admin.users.activate');

        });
    });



    //Employee
    Route::group(['namespace' => 'Employee', 'prefix' => 'orders', 'middleware' => ['employee', 'active_user']], function () {
        Route::get('/employee', 'HomeControllerEmployee@index')->name('employee.openOrders.index');
        Route::get('/filterEmployee', 'HomeControllerEmployee@filter')->name('employee.openOrders.filter');
        Route::get('/createEmployee', 'HomeControllerEmployee@create')->name('employee.openOrders.create');
        Route::get('/saveEmployee', 'HomeControllerEmployee@save')->name('employee.openOrders.save');
        Route::POST('/saveEmployee', 'HomeControllerEmployee@save')->name('employee.openOrders.save');
        Route::get('/editEmployee/{id}', 'HomeControllerEmployee@edit')->name('employee.openOrders.edit');
        Route::POST('/updateEmployee', 'HomeControllerEmployee@update')->name('employee.openOrders.update');
        Route::POST('/selectEmployee', 'HomeControllerEmployee@select')->name('employee.openOrders.select');
        Route::get('/selectEmployee', 'HomeControllerEmployee@select')->name('employee.openOrders.select');
        Route::POST('/updateSelectionEmployee', 'HomeControllerEmployee@updateSelection')->name('employee.openOrders.updateSelection');
        Route::get('/nextStatusEmployee/{id}', 'HomeControllerEmployee@nextStatus')->name('employee.openOrders.nextStatus');
        Route::get('/export_activesEmployee', 'HomeControllerEmployee@exportActives')->name('employee.export_excel.exportActives');
    });

    Route::group(['namespace' => 'Employee', 'prefix' => 'settings', 'middleware' => ['employee', 'active_user']], function () {
        Route::get('/employee', 'SettingsControllerEmployee@index')->name('employee.settings.index');
        Route::POST('/updatePassEmployee', 'SettingsControllerEmployee@updatePass')->name('employee.settings.updatePassEmployee');
        Route::POST('/updateInfoEmployee', 'SettingsControllerEmployee@updateInfo')->name('employee.settings.updateInfoEmployee');
    });

    Route::group(['namespace' => 'Employee', 'prefix' => 'materials', 'middleware' => ['employee', 'active_user']], function () {
        Route::get('/employee', 'MaterialsControllerEmployee@index')->name('employee.materials.index');
        Route::POST('/saveEmployee', 'MaterialsControllerEmployee@save')->name('employee.materials.save');
        Route::get('/deleteEmployee/{id}', 'MaterialsControllerEmployee@delete')->name('employee.materials.deleteEmployee');
    });

    Route::group(['namespace' => 'Employee', 'prefix' => 'co', 'middleware' => ['employee', 'active_user']], function () {
        Route::get('/ordersEmployee', 'ClosedOrdersControllerEmployee@index')->name('employee.closedOrders.index');
        Route::get('/editEmployee/{id}', 'HomeControllerEmployee@edit')->name('employee.closedOrders.edit');
        Route::get('/filterEmployeeCO', 'ClosedOrdersControllerEmployee@filter')->name('employee.closedOrders.filter');

        Route::POST('/updateEmployee', 'HomeControllerEmployee@update')->name('employee.closedOrders.update');
        Route::get('/export_closedEmployee', 'ClosedOrdersControllerEmployee@exportClosed')->name('employee.export_excel.exportClosed');

    });

    Route::group(['namespace' => 'Employee', 'prefix' => 'users', 'middleware' => ['employee', 'active_user']], function () {
        Route::get('/usersEmployee', 'UserControllerEmployee@index')->name('employee.users.index');

    });

    //Customer
    Route::group(['namespace' => 'Customer', 'prefix' => 'orders', 'middleware' => ['customer', 'active_user']], function () {
        Route::get('/customer', 'HomeControllerCustomer@index')->name('customer.openOrders.index');
        Route::get('/filterCustomer', 'HomeControllerCustomer@filter')->name('customer.openOrders.filter');
        Route::get('/createCustomer', 'HomeControllerCustomer@create')->name('customer.openOrders.create');
        Route::get('/editCustomer/{id}', 'HomeControllerCustomer@edit')->name('customer.openOrders.edit');
        Route::get('/export_activesCustomer', 'HomeControllerCustomer@exportActives')->name('customer.export_excel.exportActives');
    });

    Route::group(['namespace' => 'Customer', 'prefix' => 'settings', 'middleware' => ['customer', 'active_user']], function () {
        Route::get('/customer', 'SettingsControllerCustomer@index')->name('customer.settings.index');
        Route::POST('/updatePassCustomer', 'SettingsControllerCustomer@updatePass')->name('customer.settings.updatePass');
        Route::POST('/updateInfoCustomer', 'SettingsControllerCustomer@updateInfo')->name('customer.settings.updateInfo');


    });

    Route::group(['namespace' => 'Customer', 'prefix' => 'co', 'middleware' => ['customer', 'active_user']], function () {
        Route::get('/ordersCustomer', 'ClosedOrdersControllerCustomer@index')->name('customer.closedOrders.index');
        Route::get('/editCustomer/{id}', 'HomeControllerCustomer@edit')->name('customer.closedOrders.edit');
        Route::get('/filterCustomerCO', 'ClosedOrdersControllerCustomer@filter')->name('customer.closedOrders.filter');
        Route::get('/export_closedCustomer', 'ClosedOrdersControllerCustomer@exportClosed')->name('customer.export_excel.exportClosed');

    });



});
