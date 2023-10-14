<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/Routes/ProductRoutes.php';

db()->connect('localhost', 'dbsistema_cv', 'root', 'devroot', 'mysql');

app()->cors();

app()->get('/', function () {
  response()->json([
    "Hello from PHP-MVC-Project"
  ]);
});

app()->run();