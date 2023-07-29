<?php 
//redireccionar a la vista de login
// header ('Location: vistas/login.html');

require __DIR__ . '/vendor/autoload.php';

app()->cors();

app()->get('/', function () {
  response()->json([
    'message' => 'Hello World!'
  ]);
});

app()->run();