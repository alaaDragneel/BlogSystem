<?php

use System\Application;

// White List Route

$app = Application::getInstance();

// Admin Routes
$app->route->get('/admin/login', 'Admin\\LoginController@index');
$app->route->post('/admin/login/attempt', 'Admin\\LoginController@login');

// logout
$app->route->get('/logout', 'LogoutController');

// dashboard
$app->route->get('/admin', 'Admin\\DashboardController');
$app->route->get('/admin/dashboard', 'Admin\\DashboardController');

// Admin => users
$app->route->get('/admin/users', 'Admin\\UsersController');
$app->route->get('/admin/users/create', 'Admin\\UsersController@create');
$app->route->post('/admin/users/store', 'Admin\\UsersController@store');
$app->route->get('/admin/users/{id}/edit', 'Admin\\UsersController@edit');
$app->route->post('/admin/users/{id}/update', 'Admin\\UsersController@update');
$app->route->get('/admin/users/{id}/destroy', 'Admin\\UsersController@destroy');

// Admin => users-groups
$app->route->get('/admin/users-groups', 'Admin\\UsersGroupsController');
$app->route->get('/admin/users-groups/create', 'Admin\\UsersGroupsController@create');
$app->route->post('/admin/users-groups/store', 'Admin\\UsersGroupsController@store');
$app->route->get('/admin/users-groups/{id}/edit', 'Admin\\UsersGroupsController@edit');
$app->route->post('/admin/users-groups/{id}/update', 'Admin\\UsersGroupsController@update');
$app->route->get('/admin/users-groups/{id}/destroy', 'Admin\\UsersGroupsController@destroy');

// Admin => posts
$app->route->get('/admin/posts', 'Admin\\PostsController');
$app->route->get('/admin/posts/create', 'Admin\\PostsController@create');
$app->route->post('/admin/posts/store', 'Admin\\PostsController@store');
$app->route->get('/admin/posts/{id}/edit', 'Admin\\PostsController@edit');
$app->route->post('/admin/posts/{id}/update', 'Admin\\PostsController@update');

// Admin => Posts => Comments
$app->route->get('/admin/posts/{id}/comments', 'Admin\\CommentsController');
$app->route->get('/admin/posts/{id}/comments/{id}/edit', 'Admin\\CommentsController@edit');
$app->route->post('/admin/posts/{id}/comments/{id}/update', 'Admin\\CommentsController@update');
$app->route->get('/admin/posts/{id}/comments/{id}/destroy', 'Admin\\CommentsController@destroy');


// Admin => categories
$app->route->get('/admin/categories', 'Admin\\CategoriesController');
$app->route->get('/admin/categories/create', 'Admin\\CategoriesController@create');
$app->route->post('/admin/categories/store', 'Admin\\CategoriesController@store');
$app->route->get('/admin/categories/{id}/edit', 'Admin\\CategoriesController@edit');
$app->route->post('/admin/categories/{id}/update', 'Admin\\CategoriesController@update');
$app->route->get('/admin/categories/{id}/destroy', 'Admin\\CategoriesController@destroy');

// Admin => ads
$app->route->get('/admin/ads', 'Admin\\AdsController');
$app->route->get('/admin/ads/create', 'Admin\\AdsController@create');
$app->route->post('/admin/ads/store', 'Admin\\AdsController@store');
$app->route->get('/admin/ads/{id}/edit', 'Admin\\AdsController@edit');
$app->route->post('/admin/ads/{id}/update', 'Admin\\AdsController@update');
$app->route->get('/admin/ads/{id}/destroy', 'Admin\\AdsController@destroy');

// Admin Settings
$app->route->get('/admin/settings', 'Admin\\SettingsController');
$app->route->post('/admin/settings/store', 'Admin\\SettingsController@store');

// Admin Contacts
$app->route->get('/admin/contacts', 'Admin\\ContactsController');
$app->route->get('/admin/contacts/reply/{id}', 'Admin\\ContactsController@reply');
$app->route->post('/admin/contacts/send/{id}', 'Admin\\ContactsController@send');

// Not Found Routes
$app->route->get('/404', 'NotFoundController');
$app->route->notFound('/404');