<?php

use App\Controllers\AuthController;
use App\Controllers\CustomerController;
use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Controllers\KaratController;
use App\Controllers\PermissionController;
use App\Controllers\ProductController;
use App\Controllers\RoleController;
use App\Controllers\SalesOrderController;
use App\Controllers\SPKController;
use App\Controllers\UserController;
use App\Models\Permission;
use Core\Router;

$router = new Router();

$router->get('/', [DashboardController::class, 'index']);

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

// role
$router->get('/role', [RoleController::class, 'index']);
$router->get('/role/create', [RoleController::class, 'create']);
$router->post('/role/store', [RoleController::class, 'store']);
$router->get('/role/data', [RoleController::class, 'data']);
$router->get('/role/select', [RoleController::class, 'select']);
$router->get('/role/edit/{id}', [RoleController::class, 'edit']);
$router->post('/role/update/{id}', [RoleController::class, 'update']);
$router->post('/role/delete/{id}', [RoleController::class, 'delete']);

// permission
$router->get('/permission', [PermissionController::class, 'index']);
$router->get('/permission/create', [PermissionController::class, 'create']);
$router->post('/permission/store', [PermissionController::class, 'store']);
$router->get('/permission/data', [PermissionController::class, 'data']);
$router->get('/permission/select', [PermissionController::class, 'select']);
$router->get('/permission/edit/{id}', [PermissionController::class, 'edit']);
$router->post('/permission/update/{id}', [PermissionController::class, 'update']);
$router->post('/permission/delete/{id}', [PermissionController::class, 'delete']);

// user
$router->get('/user', [UserController::class, 'index']);
$router->get('/user/create', [UserController::class, 'create']);
$router->post('/user/store', [UserController::class, 'store']);
$router->get('/user/data', [UserController::class, 'data']);
$router->get('/user/select', [UserController::class, 'select']);
$router->get('/user/edit/{id}', [UserController::class, 'edit']);
$router->post('/user/update/{id}', [UserController::class, 'update']);
$router->post('/user/delete/{id}', [UserController::class, 'delete']);

// sales order
$router->get('/sales-order', [SalesOrderController::class, 'index']);
$router->get('/sales-order/create', [SalesOrderController::class, 'create']);
$router->post('/sales-order/store', [SalesOrderController::class, 'store']);
$router->get('/sales-order/data', [SalesOrderController::class, 'data']);
$router->get('/sales-order/edit/{id}', [SalesOrderController::class, 'edit']);
$router->get('/sales-order/print/{id}', [SalesOrderController::class, 'print']);
$router->post('/sales-order/update/{id}', [SalesOrderController::class, 'update']);
$router->post('/sales-order/delete/{id}', [SalesOrderController::class, 'delete']);

// spk
$router->get('/spk', [SPKController::class, 'index']);
$router->get('/spk/create', [SPKController::class, 'create']);
$router->post('/spk/store', [SPKController::class, 'store']);
$router->get('/spk/data', [SPKController::class, 'data']);
$router->get('/spk/edit/{id}', [SPKController::class, 'edit']);
$router->get('/spk/print/{id}', [SPKController::class, 'print']);
$router->post('/spk/update/{id}', [SPKController::class, 'update']);
$router->post('/spk/delete/{id}', [SPKController::class, 'delete']);