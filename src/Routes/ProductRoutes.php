<?php

require dirname(__DIR__) . '/Controllers/ProductController.php';

app()->group('api/products', function() {
    app()->get('/', "ProductController@index");
});