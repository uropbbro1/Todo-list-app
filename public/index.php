<?php
require_once __DIR__ . '/../vendor/autoload.php';

use controllers\ToDoController;
use services\ToDoService;
use repository\MySQLToDoRepository;

use controllers\UsersController;
use services\UsersService;
use repository\MySQLUsersRepository;

use controllers\AuthController;
use services\AuthService;
use repository\MySQLAuthRepository;
use repository\MySqlDashboardRepository;
use routes\Router;
use services\DashboardService;
use controllers\DashboardController;

// 🔹 Подключаем базу данных
$db = new PDO('mysql:host=mysql;dbname=todo_db', 'todo_user', 'secret');

$router = new Router();
//регистрация слоёв
$router->add(MySQLToDoRepository::class, new MySQLToDoRepository($db));
$router->add(MySQLUsersRepository::class, new MySQLUsersRepository($db));
$router->add(MySQLAuthRepository::class, new MySQLAuthRepository($db));
$router->add(MySqlDashboardRepository::class, new MySqlDashboardRepository($db));

$router->add(ToDoService::class, new ToDoService($router->get(MySQLToDoRepository::class)));
$router->add(UsersService::class, new UsersService($router->get(MySQLUsersRepository::class)));
$router->add(AuthService::class, new AuthService($router->get(MySQLAuthRepository::class)));
$router->add(DashboardService::class, new DashboardService($router->get(MySqlDashboardRepository::class)));

$router->add(ToDoController::class, new ToDoController($router->get(ToDoService::class)));
$router->add(UsersController::class, new UsersController($router->get(UsersService::class)));
$router->add(AuthController::class, new AuthController($router->get(AuthService::class)));
$router->add(DashboardController::class, new DashboardController($router->get(DashboardService::class)));



$router->addRoute('GET', '/', [UsersController::class, 'index']);

$router->addRoute('POST', '/register', [AuthController::class, 'register']);
$router->addRoute('POST', '/login', [AuthController::class, 'login']);
$router->addRoute('GET', '/logout', [AuthController::class, 'logout']);

$router->addRoute('GET', '/todos', [ToDoController::class, 'getToDosById']);
$router->addRoute('POST', '/create-task', [ToDoController::class, 'create']);
$router->addRoute('POST', '/update-task', [ToDoController::class, 'update']);
$router->addRoute('POST', '/delete-task', [ToDoController::class, 'delete']);
$router->addRoute('POST', '/sort-by-status', [ToDoController::class, 'sortByStatus']);
$router->addRoute('POST', '/sort-by-data', [ToDoController::class, 'sortByDate']);

$router->addRoute('GET', '/profile', [UsersController::class, 'getUser']);
$router->addRoute('POST', '/update-profile', [UsersController::class, 'updateUser']);

$router->addRoute('GET', '/dashboard', [DashboardController::class, 'getDashboard']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);