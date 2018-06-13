<?php

// white list routes

use System\Application;

$app = Application::getInstance();

$app->route->get('/posts/{text}/{id}', 'UsersController');
