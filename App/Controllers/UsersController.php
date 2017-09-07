<?php

namespace App\Controllers;

use System\Controller;

class UsersController extends Controller
{
    public function index()
    {
        dd($this->session->get('name'));
    }
}
