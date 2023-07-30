<?php 
require __DIR__ . '/vendor/autoload.php';

app()->cors();

app()->get('/', function () {
  response()->json([
    'message' => 'Hello World!'
  ]);
});

app()->run();