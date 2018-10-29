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


Auth::routes();
Route::post('/forgot-password', 'Auth\ForgotPasswordController@sendMail')->name('forgot.sendMail');
Route::match(['get', 'post'], '/forgot-reset-password/{token}', 'Auth\ForgotPasswordController@resetPassword')->name('forgot.resetPassword');

Route::get('/', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth','permissions']], function () {
    Route::group(['prefix' => 'user-manager'], function () {
        Route::get('/', 'UserAdminController@index')->name('user-admin.index');
        Route::get('show/{id}', 'UserAdminController@show')->name('user-admin.show');
        Route::get('create', 'UserAdminController@create')->name('user-admin.create');
        Route::post('store', 'UserAdminController@store')->name('user-admin.store');
        Route::get('{id}/edit', 'UserAdminController@edit')->name('user-admin.edit');
        Route::post('update/{id}', 'UserAdminController@update')->name('user-admin.update');
        Route::get('destroy/{id}', 'UserAdminController@destroy')->name('user-admin.destroy');
    });

    Route::group(['prefix' => 'phone'], function () {
        Route::get('/', 'PhoneController@index')->name('phone.index');
        Route::get('show/{id}', 'PhoneController@show')->name('phone.show');
        Route::get('create', 'PhoneController@create')->name('phone.create');
        Route::post('store', 'PhoneController@store')->name('phone.store');
        Route::get('{id}/edit', 'PhoneController@edit')->name('phone.edit');
        Route::post('update/{id}', 'PhoneController@update')->name('phone.update');
        Route::get('destroy/{id}', 'PhoneController@destroy')->name('phone.destroy');
        Route::get('buy-new', 'PhoneController@buyNewNumberPhone')->name('phone.buyNewNumberPhone');
        Route::get('buy-new/{id}', 'PhoneController@doBuyNewNumberPhone')->name('phone.doBuyNewNumberPhone');
        Route::get('list-number', 'PhoneController@listNumberBought')->name('phone.listNumberBought');
        Route::get('delete-cycle', 'PhoneController@deleteCycle')->name('phone.deleteCycle');
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'CategoryController@index')->name('category.index');
        Route::get('show/{id}', 'CategoryController@show')->name('category.show');
        Route::get('create', 'CategoryController@create')->name('category.create');
        Route::post('store', 'CategoryController@store')->name('category.store');
        Route::get('{id}/edit', 'CategoryController@edit')->name('category.edit');
        Route::post('update/{id}', 'CategoryController@update')->name('category.update');
        Route::get('destroy/{id}', 'CategoryController@destroy')->name('category.destroy');
        Route::get('addPhone', 'CategoryController@addPhoneToCategory')->name('category.addPhoneToCategory');
        Route::post('addPhone', 'CategoryController@doAddPhoneToCategory')->name('category.doAddPhoneToCategory');
    });

    Route::group(['prefix' => 'transaction-manager'], function () {
        Route::get('/', 'TransactionController@index')->name('transaction-manager.index');
        Route::get('manager', 'TransactionController@manager')->name('transaction-manager.manager');
        Route::get('create', 'TransactionController@create')->name('transaction-manager.create');
        Route::get('individual', 'TransactionController@individual')->name('transaction-manager.individual');
        Route::post('store', 'TransactionController@store')->name('transaction-manager.store');
        Route::get('/show/{id}', 'TransactionController@show')->name('transaction-manager.show');
        Route::get('{id}/edit', 'TransactionController@edit')->name('transaction-manager.edit');
        Route::post('update/{id}', 'TransactionController@update')->name('transaction-manager.update');
        Route::get('destroy/{id}', 'TransactionController@destroy')->name('transaction-manager.destroy');
    });
    Route::group(['prefix' => 'permission'], function () {
        Route::get('/', 'PermissionController@index')->name('permission.index');
        Route::get('/tool', 'PermissionController@tool')->name('permission.tool');
        Route::get('show/{id}', 'PermissionController@show')->name('permission.show');
        Route::get('create', 'PermissionController@create')->name('permission.create');
        Route::post('store', 'PermissionController@store')->name('permission.store');
        Route::get('{id}/edit', 'PermissionController@edit')->name('permission.edit');
        Route::post('update/{id}', 'PermissionController@update')->name('permission.update');
        Route::get('destroy/{id}', 'PermissionController@destroy')->name('permission.destroy');
    });
    Route::group(['prefix' => 'role'], function () {
        Route::get('/', 'RoleController@index')->name('role.index');
        Route::get('show/{id}', 'RoleController@show')->name('role.show');
        Route::get('create', 'RoleController@create')->name('role.create');
        Route::post('store', 'RoleController@store')->name('role.store');
        Route::get('{id}/edit', 'RoleController@edit')->name('role.edit');
        Route::post('update/{id}', 'RoleController@update')->name('role.update');
        Route::get('destroy/{id}', 'RoleController@destroy')->name('role.destroy');
    });
    Route::group(['prefix' => 'role'], function () {
        Route::get('/', 'RoleController@index')->name('role.index');
        Route::get('show/{id}', 'RoleController@show')->name('role.show');
        Route::get('create', 'RoleController@create')->name('role.create');
        Route::post('store', 'RoleController@store')->name('role.store');
        Route::get('{id}/edit', 'RoleController@edit')->name('role.edit');
        Route::post('update/{id}', 'RoleController@update')->name('role.update');
        Route::get('destroy/{id}', 'RoleController@destroy')->name('role.destroy');
    });
    Route::group(['prefix' => 'action-group'], function () {
        Route::match(['post', 'get'], '/', 'ActionGroupController@index')->name('ActionGroup_index');
        Route::match(['post', 'get'], '/add', 'ActionGroupController@add')->name('ActionGroup_add');
        Route::match(['post', 'get'], '/edit/{id}', 'ActionGroupController@edit')->name('ActionGroup_edit');
        Route::match(['post', 'get'], '/delete/{id}', 'ActionGroupController@delete')->name('ActionGroup_delete');
    });

    Route::get('/import','HomeController@import')->name('Home_import');
    Route::post('/import','HomeController@doImport')->name('Home_doImport');
});

