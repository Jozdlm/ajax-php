<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/Routes/ProductRoutes.php';

db()->connect('localhost', 'dbsistema_cv', 'root', 'devroot', 'mysql');

app()->cors();

app()->get('/', function () {
  $products = db()->query('SELECT * FROM products')->all();

  response()->json([
    'data' => $products,
    'count' => count($products)
  ]);
});

app()->run();