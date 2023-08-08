<?php

namespace NextG\RwAdminApp\Services\AuthServices;

interface LoginServices
{
    public function login(string $username,  string $password);
}
