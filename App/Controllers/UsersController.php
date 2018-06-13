<?php

namespace App\Controllers;

use System\Controller;

use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = $this->load->model('User');


        dd($users->find(1));
    }
}
