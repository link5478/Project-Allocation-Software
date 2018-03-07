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

use Illuminate\Routing\Router;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', 'HomeController@index')->name('home');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

/**
 * AUTH ROUTES
 */
$router->group([
    'middleware' => ['web', 'auth']
], function (Router $router) {
    $router->post('logout', 'Auth\LoginController@logout')->name('logout');

    $router->get('projects', 'ProjectController@index')->name('projects');
    //$router->get('projects/{id}', 'ProjectController@show')->name('projects');
    $router->get('projects/{id}/edit', 'ProjectController@edit')->name('projects.edit');
    $router->put('projects/{project}', 'ProjectController@update')->name('projects.update');

    $router->get('projects/add', 'ProjectController@add')->name('projects.add');
    $router->put('projects/add/save', 'ProjectController@store')->name('projects.save');
});