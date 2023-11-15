<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'];
require_once("{$projectRoot}/src/CategoryController.php");

$httpMethod = $_SERVER['REQUEST_METHOD'];
$id = $_REQUEST['id'] ?? null;
$controller = new CategoryController();

match ($httpMethod) {
    'GET' => ($id) ? $controller->getCategoryById($id) : $controller->getCategories(),
    'POST' => ($id) ? $controller->enableCategory($id) : $controller->createCategory(),
    'PUT' => $controller->updateCategory($id),
    'DELETE' => $controller->disableCategory($id),
};
