<?php

use App\Controllers\AuthController;
use App\Controllers\CustomerController;
use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Controllers\KaratController;
use App\Controllers\ProductController;
use App\Controllers\SalesOrderController;
use Core\Router;

$router = new Router();

$router->get('/', [HomeController::class, 'index']);

// Auth routes
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/dashboard', [DashboardController::class, 'index']);

// product
$router->get('/products', [ProductController::class, 'index']);
$router->get('/products/create', [ProductController::class, 'create']);
$router->post('/products/store', [ProductController::class, 'store']);
$router->get('/products/data', [ProductController::class, 'data']);
$router->get('/products/edit/{id}', [ProductController::class, 'edit']);
$router->post('/products/update/{id}', [ProductController::class, 'update']);
$router->post('/products/delete/{id}', [ProductController::class, 'delete']);
// $router->post('/products/delete/(\d+)', [ProductController::class, 'delete']);

// karat
$router->get('/karat/select', [KaratController::class, 'select']);
$router->get('/karat/salesSelect', [KaratController::class, 'salesSelect']);

// customer
$router->get('/customer', [CustomerController::class, 'index']);
$router->get('/customer/create', [CustomerController::class, 'create']);
$router->post('/customer/store', [CustomerController::class, 'store']);
$router->get('/customer/data', [CustomerController::class, 'data']);
$router->get('/customer/select', [CustomerController::class, 'select']);
$router->get('/customer/edit/{id}', [CustomerController::class, 'edit']);
$router->post('/customer/update/{id}', [CustomerController::class, 'update']);
$router->post('/customer/delete/{id}', [CustomerController::class, 'delete']);

// sales order
$router->get('/sales-order', [SalesOrderController::class, 'index']);
$router->get('/sales-order/create', [SalesOrderController::class, 'create']);
$router->post('/sales-order/store', [SalesOrderController::class, 'store']);
$router->get('/sales-order/data', [SalesOrderController::class, 'data']);
$router->get('/sales-order/edit/{id}', [SalesOrderController::class, 'edit']);
$router->get('/sales-order/print/{id}', [SalesOrderController::class, 'print']);
$router->post('/sales-order/update/{id}', [SalesOrderController::class, 'update']);
$router->post('/sales-order/delete/{id}', [SalesOrderController::class, 'delete']);