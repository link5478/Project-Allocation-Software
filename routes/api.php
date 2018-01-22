<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//API ROUTES
$router->group([
    'as' => 'api.'
], function (Router $router) {
    $router->get('/projects/{supervisorID}', 'APIController@supervisorGetProjects')->name('projects.supervisor_get');
    $router->put('/projects/add', 'APIController@supervisorAddProject')->name('projects.supervisor_add');
    $router->put('/projects/edit', 'APIController@supervisorEditProject')->name('projects.supervisor_edit');

});