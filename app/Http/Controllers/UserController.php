<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends BaseController
{

    public function index(){
        $users = User::paginate(10);
        return $this->sendResponse($users);
    }
}
