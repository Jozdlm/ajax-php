<?php

require dirname(__DIR__) . '/Controllers/ProductController.php';

app()->group('api/products', function() {
    app()->get('/', "ProductController@index");
    
    app()->patch('/enable/{id}', "ProductController@enable");
    app()->get('/{id}', "ProductController@show");
});