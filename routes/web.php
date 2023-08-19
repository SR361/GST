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
Route::get('/', function () {
	return redirect()->guest('/login');
});



Auth::routes();


Route::group(['middleware' => 'auth','prefix' => '{locale}','where' => ['locale' => '[a-zA-Z]{2}'],
  'middleware' => 'setlocale'], function () {

  	Route::get('/plan_expire', '\App\Http\Controllers\DashboardController@plan_expire');

  	Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

  });

Route::group(['middleware' => ['auth','setlocale','check_plan'],'prefix' => '{locale}','where' => ['locale' => '[a-zA-Z]{2}']], function () {

	Route::get('/dashboard', 'DashboardController@versionone')->name('home');
	Route::resource('clients','ClientController');
	Route::post('/clients/getlist','ClientController@getlist')->name('clientdataProcessing');
	Route::post('/clientsdata','ClientController@data')->name('clientdatainfo');
	Route::post('/clientsmuldel','ClientController@multydestroy');
	Route::delete('/clientsdelete/{id}', 'ClientController@destroy');


	Route::resource('products','ProductController');
	Route::post('/products/getlist','ProductController@getlist')->name('productdataProcessing');
	Route::post('/productsdata','ProductController@data')->name('productdatainfo');
	Route::post('/productsmuldel','ProductController@multydestroy');
	Route::delete('/productsdelete/{id}', 'ProductController@destroy');


	Route::resource('invoices','InvoiceController');
	Route::post('/invoices/getlist','InvoiceController@getlist')->name('invoicedataProcessing');
	Route::post('/invoicesdata','InvoiceController@data')->name('invoicedatainfo');
	Route::get('/{id}/invoicebill','InvoiceController@invoice')->name('invoice');
	Route::post('/invoices/clientinfo','InvoiceController@clientinfo')->name('invoicesclientinfo');
	Route::post('/invoices/productinfo','InvoiceController@productinfo')->name('invoicesproductinfo');
	Route::post('/invoices/addclient','InvoiceController@addclient')->name('invoicesadd_client');
	Route::post('/invoices/addproduct','InvoiceController@addproduct')->name('invoicesadd_product');
	Route::post('/invoicesmuldel','InvoiceController@multydestroy');
	Route::delete('/invoicesdelete/{id}', 'InvoiceController@destroy');
	Route::get('/{id}/generatepdf','InvoiceController@generatePDF')->name('invoicegeneratePDF');




	Route::resource('supplybills','SupplybillController');
	Route::post('/supplybills/getlist','SupplybillController@getlist')->name('supplybilldataProcessing');
	Route::post('/supplybillsdata','SupplybillController@data')->name('supplybilldatainfo');
	Route::get('/{id}/supplybills','SupplybillController@supplybill')->name('supplybill');
	Route::post('/supplybillsmuldel','SupplybillController@multydestroy');
	Route::delete('/supplybillsdelete/{id}', 'SupplybillController@destroy');




	Route::resource('quotebills','QuotebillController');
	Route::post('/quotebills/getlist','QuotebillController@getlist')->name('quotebilldataProcessing');
	Route::post('/quotebillsdata','QuotebillController@data')->name('quotebilldatainfo');
	Route::get('/{id}/quotebills','QuotebillController@quotebill')->name('quotebill');
	Route::post('/quotebillsmuldel','QuotebillController@multydestroy');
	Route::delete('/quotebillsdelete/{id}', 'QuotebillController@destroy');


	Route::resource('purchasebills','PurchasebillController');
	Route::post('/purchasebills/getlist','PurchasebillController@getlist')->name('purchasebilldataProcessing');
	Route::post('/purchasebillsdata','PurchasebillController@data')->name('purchasebilldatainfo');
	Route::get('/{id}/purchasebills','PurchasebillController@purchasebill')->name('purchasebill');
	Route::post('/purchasebillsmuldel','PurchasebillController@multydestroy');
	Route::delete('/purchasebillsdelete/{id}', 'PurchasebillController@destroy');
	Route::post('/converttobill','PurchasebillController@converttobill')->name('convert_to_bill');



	Route::resource('bills','BillController');
	Route::post('/bills/getlist','BillController@getlist')->name('billdataProcessing');
	Route::post('/billsdata','BillController@data')->name('billdatainfo');
	Route::get('/{id}/bills','BillController@bill')->name('bill');
	Route::post('/billsmuldel','BillController@multydestroy');
	Route::delete('/billsdelete/{id}', 'BillController@destroy');


	Route::resource('payments','PaymentController');
	Route::get('/payments/{type}/create','PaymentController@create')->name('paymentcreate');
	Route::get('/payments/{type}/{id}/edit','PaymentController@edit')->name('paymentedit');
	Route::post('/payments/paymentinfo','PaymentController@clientpaymentinfo')->name('clientpaymentinfo');
	Route::post('/payments/getlist','PaymentController@getlist')->name('paymentdataProcessing');
	Route::post('/paymentsdata','PaymentController@data')->name('paymentdatainfo');
	Route::get('/{id}/payments','PaymentController@payment')->name('payment');
	Route::post('/paymentsmuldel','PaymentController@multydestroy');
	Route::delete('/paymentsdelete/{id}', 'PaymentController@destroy');


	Route::resource('credits','CreditController');
	Route::post('/credits/clientinvoiceinfo','CreditController@clientinvoiceinfo')->name('clientinvoiceinfo');
	Route::post('/credits/invoiceproductinfo','CreditController@invoiceproductinfo')->name('invoiceproductinfo');
	Route::post('/credits/getlist','CreditController@getlist')->name('creditdataProcessing');
	Route::post('/creditsdata','CreditController@data')->name('creditdatainfo');
	Route::get('/{id}/credits','CreditController@credit')->name('credit');
	Route::post('/creditsmuldel','CreditController@multydestroy');
	Route::delete('/creditsdelete/{id}', 'CreditController@destroy');



	Route::resource('settings', 'SettingsController');
	Route::post('/settingsupdateuser','SettingsController@updateuser')->name('setting_update_user');
	Route::post('/settingsupdateusergeneral','SettingsController@updateusergeneral')->name('setting_update_user_general');
	Route::post('/settingsupdatothers','SettingsController@settingsupdatothers')->name('settingsupdatothers');


	Route::resource('roles','RoleController');
	Route::post('/roles/update','RoleController@update_data')->name('roleupdate');
	Route::post('/roles/getlist','RoleController@getlist')->name('roledataProcessing');
	Route::post('/rolesmuldel','RoleController@multydestroy');
	Route::delete('/rolesdelete/{id}', 'RoleController@destroy');
	Route::post('/update_visible','RoleController@update_visible')->name('update_visible');
	Route::post('/visible_data','RoleController@visible_data')->name('visible_data');


	Route::resource('employees','EmpController');
	Route::post('/employees/getlist','EmpController@getlist')->name('employeedataProcessing');
	Route::post('/employeesmuldel','EmpController@multydestroy');
	Route::delete('/employeesdelete/{id}', 'EmpController@destroy');

	// Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
	Route::get('/updatePassword', 'DashboardController@updatePassword');
	Route::post('/visible','VisibleController@update');
});

Route::prefix('/admin')->group(function(){

	Route::get('/','\App\Http\Controllers\Auth\AdminLoginController@showLoginForm')->name('admin.auth.login');
	Route::post('/login', '\App\Http\Controllers\Auth\AdminLoginController@loginAdmin');
	Route::post('/register', '\App\Http\Controllers\Auth\AdminLoginController@createAdmin')->name('admin.register');
	Route::get('/register', '\App\Http\Controllers\Auth\AdminLoginController@showRegistartionForm');
	Route::get('logout/', '\App\Http\Controllers\Auth\AdminLoginController@logout')->name('admin.logout');
	Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard');
	Route::get('/updatePassword', 'AdminController@updatePassword');


	Route::resource('users','UsersController');
	Route::post('/users/getlist','UsersController@getlist')->name('usersdataProcessing');
	Route::post('/usersmuldel','UsersController@multydestroy');
	Route::delete('/usersdelete/{id}', 'UsersController@destroy');

});
