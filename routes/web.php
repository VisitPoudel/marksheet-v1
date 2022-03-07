<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post("/v1/api/login", ["uses" => "AuthController@login"]);

$router->group(['prefix' => '/v1/api', 'middleware' => 'auth'], function () use ($router) {
    $router->group(['prefix' => '/class'], function () use ($router) {
        $router->get("/", ["uses" => "ClassController@index"]);
        $router->post("/", ["uses" => "ClassController@store"]);
        $router->put("/{class_id}", ["uses" => "ClassController@update"]);
        $router->delete("/{class_id}", ["uses" => "ClassController@delete"]);
        $router->get("/get-average/{class_id}", ["uses" => "ClassController@average"]);
    });

    $router->group(['prefix' => '/students'], function () use ($router) {
        $router->get("/", ["uses" => "StudentController@index"]);
        $router->post("/", ["uses" => "StudentController@store"]);
        $router->put("/{student_id}", ["uses" => "StudentController@update"]);
        $router->delete("/{student_id}", ["uses" => "StudentController@delete"]);
    });

    $router->group(['prefix' => '/subjects'], function () use ($router) {
        $router->get("/", ["uses" => "SubjectController@index"]);
        $router->post("/", ["uses" => "SubjectController@store"]);
        $router->put("/{subject_id}", ["uses" => "SubjectController@update"]);
        $router->delete("/{subject_id}", ["uses" => "SubjectController@delete"]);
    });

    $router->group(['prefix' => '/marks'], function () use ($router) {
        $router->get("/", ["uses" => "MarkController@index"]);
        $router->post("/", ["uses" => "MarkController@store"]);
        $router->put("/{mark_id}", ["uses" => "MarkController@update"]);
        $router->delete("/{mark_id}", ["uses" => "MarkController@delete"]);
        $router->get("/marksheet/{student_id}", ["uses" => "MarkController@marksheet"]);
    });
});
