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

    return view('auth.login');
    });


// AUTHENTICATION ROUTES
Route::get('login', [
	'as' => 'login',
	'uses' => 'Auth\LoginController@showLoginForm'
  ]);
  Route::post('login', [
	'as' => '',
	'uses' => 'Auth\LoginController@login'
  ]);
  Route::post('logout', [
	'as' => 'logout',
	'uses' => 'Auth\LoginController@logout'
  ]);

  // PASSWORD RESET ROUTES
  Route::post('password/email', [
	'as' => 'password.email',
	'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
  ]);

  // ROUTE FOR FORGOTPASSWORD CONTROLLER
  Route::get('password/reset', [
	'as' => 'password.request',
	'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
  ]);
  // ROUTE FOR RESETPASSWORD CONTROLLER
  Route::post('password/reset', [
	'as' => 'password.update',
	'uses' => 'Auth\ResetPasswordController@reset'
  ]);

  // ROUTE FOR RESETPASSWORD WITH TOKEN
  Route::get('password/reset/{token}', [
	'as' => 'password.reset',
	'uses' => 'Auth\ResetPasswordController@showResetForm'
  ]);

// ROUTE FOR NEW VIEW/BLADE USER CHANGE PASSWORD
Route::get('/change_password', function () {
    return view('auth.passwords.new_user_change_pwd');
});

// ROUTE FOR CHANGE PASSWORD
Route::post('/change_password', 'ChangePasswordController@updateNewuser');
Route::resource('/change-password', 'ChangePasswordController');
Route::post('/change-password', 'ChangePasswordController@update');

// ROUTE FOR CHECKUSERSTATUS MIDDLEWARE
Route::group(['middleware' => 'CheckUserStatus'], function () {

    // ROUTE FOR VALIDATE BUTTON HISTORY MIDDLEWARE
    Route::group(['middleware' => 'ValidateButtonHistory'], function () {

        // ROUTE FOR AUTH MIDDLEWARE
        Route::group(['middleware' => 'auth'], function () {

            // HOME ROUTE CONTROLLER
            Route::get('/home', 'HomeController@index')->name('home');

            //  VIEW USER ROUTE CONTROLLER
            Route::resource('/view-users', 'ViewUsersController');
            Route::post('/view-users', 'ViewUsersController@store');
            Route::get('/reset/{id}', 'ViewUsersController@resetpwd');
            Route::get('/view-users/profile', 'ViewUsersController@show');
            Route::get('/view/all/users', 'ViewUsersController@allSystemsUsers');


            // ROUTE FOR PERMISSIONS
            Route::get('/settings/manage_users/permissions/entrust_user', 'PermissionsController@entrust_user');
            Route::get('/settings/manage_users/permissions/entrust', 'PermissionsController@entrust');
            Route::post('/settings/manage_users/permissions/entrust_usr', 'PermissionsController@entrust_user_permissions');
            Route::get('/settings/manage_users/permissions/entrustRole', 'PermissionsController@entrust_roles');
            Route::post('/settings/manage_users/permissions/entrust_role_permissions', 'PermissionsController@entrust_role_permissions');
            Route::get('/settings/manage_users/permissions/entrust_role', 'PermissionsController@entrust_role');
            Route::resource('/settings/manage_users/permissions/', 'PermissionsController');

            // ROUTES FOR ROLES
            Route::get('/settings/manage_users/roles/entrust', 'RolesController@get_roles');
            Route::post('/settings/manage_users/roles/entrust', 'RolesController@post_roles');
            Route::get('/settings/manage_users/roles/add', 'RolesController@add');
            Route::resource('/settings/manage_users/roles', 'RolesController');
        });
    });
});



