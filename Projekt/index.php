<?php
require 'core/bootstrap.php';

$routes = [
	'/createassignment' => 'CreateAssignmentController@index',
	'/changeassignment' => 'ChangeAssignmentController@changeassignment',
	'/validate' => 'CreateAssignmentController@validate',
	'/assignments' => 'AssignmentController@index',
	'/create-model' => 'CreateAssignmentController@create',
];

$db = [
	'name'     => 'reparaturwerkstatt',
	'username' => 'root',
	'password' => '',
];

$router = new Router($routes);
$router->run($_GET['url'] ?? '');