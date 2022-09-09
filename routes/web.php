<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/* |-------------------------------------------------------------------------- | Application Routes |-------------------------------------------------------------------------- | | Here is where you can register all of the routes for an application. | It is a breeze. Simply tell Lumen the URIs it should respond to | and give it the Closure to call when that URI is requested. | */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'note'], function () use ($router) {
    $router->post('/', ['as' => 'note.create', 'uses' => 'NoteController@postNote']);
    $router->delete('/{name}', ['as' => 'note.delete', 'uses' => 'NoteController@deleteNote']);
    $router->get('/{name}', ['as' => 'note.read.one', 'uses' => 'NoteController@getNoteByName']);
    $router->put('/{name}', ['as' => 'note.update', 'uses' => 'NoteController@putNoteNewValues']);
});