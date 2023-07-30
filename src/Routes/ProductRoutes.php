<?php

require dirname(__DIR__) . '/Controllers/ProductController.php';

app()->group('/products', function() {
    app()->get('/', "ProductController@index");
});