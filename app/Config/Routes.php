<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//api
$routes->group("api",function($routes){
$routes->post("create-employee","EmployeesController::createEmploye");
$routes->get("list-employees","EmployeesController::listEmployees");
$routes->get("single-employee/(:num)","EmployeesController::singleEmployeeDetail/$1");
$routes->put("update-employee/(:num)","EmployeesController::editEmployee/$1");
$routes->delete("delete-employee/(:num)","EmployeesController::deleteEmployee/$1");


});