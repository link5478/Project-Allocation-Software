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
    return view('auth.login');
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
});

$router->group([
    'middleware' => ['web', 'auth', 'supervisor']
], function (Router $router) {

    $router->get('my/projects', 'SupervisorController@index')->name('supervisor.projects');
    $router->get('my/projects/{id}/edit', 'SupervisorController@edit')->name('supervisor.projects.edit');
    $router->put('my/projects/{project}', 'SupervisorController@update')->name('supervisor.projects.update');

    $router->get('my/projects/add', 'SupervisorController@add')->name('supervisor.projects.add');
    $router->put('my/projects/add/save', 'SupervisorController@store')->name('supervisor.projects.save');

    $router->get('my/projects/{id}/archive', 'SupervisorController@archive')->name('supervisor.projects.archive');
    $router->get('my/projects/{id}/clone', 'SupervisorController@clone')->name('supervisor.projects.clone');


    $router->get('archive/projects', 'ArchiveController@index')->name('archive.projects');
    $router->get('archive/projects/{id}/restore', 'ArchiveController@restore')->name('archive.projects.restore');

    $router->get('archive/project/{id}', 'ArchiveController@show')->name('archive.project');
});


$router->group([
    'middleware' => ['web', 'auth', 'student']
], function (Router $router) {

    $router->get('projects', 'StudentController@index')->name('student.projects');
    $router->get('projects/{id}/interest', 'StudentController@addInterest')->name('student.add_interest');
    $router->get('projects/choices', 'StudentController@viewChoices')->name('student.choices');
    $router->put('projects/choices/{choice}', 'StudentController@update')->name('student.choices.update');
    $router->get('interest_toggle', 'StudentController@interested_toggle')->name('interest_toggle');
});

$router->group([
    'middleware' => ['web', 'auth', 'coordinator']
], function (Router $router) {

    $router->get('sessions', 'CoordinatorController@ShowSessions')->name('coordinator.sessions');
    $router->post('sessions/create', 'CoordinatorController@CreateSession')->name('coordinator.sessions.create');
    $router->put('sessions/update', 'CoordinatorController@UpdateSession')->name('coordinator.sessions.update');

});




$router->group([
    'middleware' => ['web']
], function (Router $router) {

    $router->get('project/{id}', 'SupervisorController@show')->name('project');
    $router->get('error', 'HomeController@SessionError')->name('error.session');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
