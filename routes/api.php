<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',[
        'namespace' => 'App\Http\Controllers\Api',
        'middleware' => ['serializer:array', 'bindings']
    ], function($api) {
        $api->get('topics/{topic}/replies', 'RepliesController@index')
        ->name('api.topics.replies.index');
});

