<?php

namespace NextG\RwAdminApp\Services\AuthServices;

interface AuthServices
{
    public function getAuth();
    public function updateAuthAcces($id, $data);
    public function getAccess() : array;

    public function addAuth($obj);
}
