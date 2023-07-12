<?php

namespace NextG\RwAdminApp\Controllers;

use NextG\RwAdminApp\App\View;
use NextG\RwAdminApp\Services\UserServices\Impl\UserServiceImpl;
use NextG\RwAdminApp\Services\UserServices\UserService;


class UserController
{
    private UserService $userService;

    public function index()
    {

        $users = $this->getDataUser();

        if ($users == null) {
            $users = [];
        }

        View::render('layouts/app', 'users/user', $users);
    }

    private function getDataUser($start = 0, $limit = 10)
    {
        $this->userService = new UserServiceImpl;
        return $this->userService->getUser($start, $limit);
    }
}
