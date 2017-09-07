<?php

// white list routes

use System\Application;

$app = Application::getInstance();

$app->route->add('/', 'Main/Home');

$app->route->add('/posts/{text}/{id}', 'posts/post');

$app->route->add('/404', 'Error/Not Found');

$app->route->notFound('/404');
