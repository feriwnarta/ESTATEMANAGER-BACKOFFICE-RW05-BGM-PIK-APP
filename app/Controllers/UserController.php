<?php

namespace NextG\RwAdminApp\Controllers;

use NextG\RwAdminApp\App\View;
use NextG\RwAdminApp\Services\UserServices\Impl\UserServiceImpl;
use NextG\RwAdminApp\Services\UserServices\UserService;




class UserController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserServiceImpl;
    }

    public function updateUser()
    {
        // json data
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        // jika data post kosong
        if (!isset($obj) || empty($obj)) {

            http_response_code(400);
            echo json_encode(
                array(
                    'message' => 'parameter empty'
                ),
                JSON_PRETTY_PRINT
            );

            return;
        }

        if (!isset($obj['username']) || !isset($obj['email']) || !isset($obj['name']) || !isset($obj['no_telp']) || !isset($obj['id_auth']) || !isset($obj['id_user'])) {
            http_response_code(400);
            echo json_encode(
                array(
                    'message' => 'parameter empty'
                ),
                JSON_PRETTY_PRINT
            );
            return;
        }


        $username = $obj['username'];
        $email = $obj['email'];
        $name = $obj['name'];
        $no_telp = $obj['no_telp'];
        $id_auth = $obj['id_auth'];
        $id_user = $obj['id_user'];

        $data = [
            'username' => $username,
            'email' => $email,
            'name' => $name,
            'no_telp' => $no_telp,
            'id_auth' => $id_auth,
            'id_user' => $id_user
        ];

        $rs = $this->userService->updateUser($id_user, $data);

        if ($rs == null) {
            http_response_code(400);
            echo json_encode(
                array(
                    'message' => 'failed update'
                ),
                JSON_PRETTY_PRINT
            );
            return;
        }


        http_response_code(200);
        echo json_encode(
            array(
                'message' => 'succes update user'
            ),
            JSON_PRETTY_PRINT
        );
        return;
    }

    public function getAllStatus()
    {
        return $this->userService->getAllStatus();
    }

    public function detailUser()
    {
        // json data
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        // jika data post kosong
        if (!isset($obj) || empty($obj)) {

            http_response_code(400);
            echo json_encode(
                array(
                    'message' => 'parameter empty'
                ),
                JSON_PRETTY_PRINT
            );

            return;
        }

        $idUser = $obj['id_user'];
        $user = $this->userService->detailUser($idUser);
        $status = $this->getAllStatus();

        if (empty($user) || $user == null) {
            return [];
        }

        $data = array(
            "status" => "success",
            "message" => "success get data",
            "data" => [
                "user" => $user,
                "status" => $status
            ]
        );

        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function deleteUser()
    {
        // json data
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        // jika data post kosong
        if (!isset($obj) || empty($obj)) {

            http_response_code(400);
            echo json_encode(
                array(
                    'message' => 'parameter empty'
                ),
                JSON_PRETTY_PRINT
            );

            return;
        }

        $idUser = $obj['id_user'];
        $affectedRows = $this->userService->deleteUser($idUser);

        // gagal delete user
        if ($affectedRows == 0) {
            http_response_code(400);
            echo json_encode(
                array(
                    'message' => 'delete failed',
                )
            );
            return;
        }

        // berhasil delete user
        http_response_code(200);
        echo json_encode(
            array(
                'message' => 'success delete user'
            )
        );
    }

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
        return $this->userService->getUser($start, $limit);
    }
}
