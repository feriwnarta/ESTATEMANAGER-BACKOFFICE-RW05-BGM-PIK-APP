<?php

namespace NextG\RwAdminApp\Services\UserServices;

interface UserService
{

    public function getUser(int $start, int $limit);

    public function deleteUser(string $idUser);

    public function detailUser(string $idUser);

    public function getAllStatus();

    public function updateUser(string $idUser, array $data);
}
