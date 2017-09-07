<?php

namespace App\Controllers;

use System\Controller;

class UsersController extends Controller
{
    public function index()
    {
        $this->response->setHeader('name', 'AlaaDragneel');
        $user_name = 'Alaaragneel';
        $user_last_login = date('Y-m-d h:i:s');

        return $this->view->render('blog.home', compact('user_name', 'user_last_login'));

    }
}
