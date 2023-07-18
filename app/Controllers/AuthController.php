<?php

namespace NextG\RwAdminApp\Controllers;

use NextG\RwAdminApp\App\View;
use NextG\RwAdminApp\Services\AuthServices\AuthServices;
use NextG\RwAdminApp\Services\AuthServices\Impl\AuthServiceImpl;

class AuthController
{

    private AuthServices $authService;

    public function __construct()
    {
        $this->authService = new AuthServiceImpl;
    }

    public function updateAuthAcces()
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

        $id = $obj['id_auth'];
        $access = $obj['access'];
        $warga = $access['warga'];
        $management = $access['management'];
        $estate_manager = $access['estate_manager'];
        $manager_kontraktor = $access['manager_kontraktor'];
        $kepala_kontraktor = $access['kepala_kontraktor'];
        $kordinator_lapangan = $access['kordinator_lapangan'];
        $danru = $access['danru'];
        $otp = $access['otp'];

        $data = [
            "warga" => $warga,
            "management" => $management,
            "estate_manager" => $estate_manager,
            "manager_kontraktor" => $manager_kontraktor,
            "kepala_kontraktor" => $kepala_kontraktor,
            "kordinator_lapangan" => $kordinator_lapangan,
            "danru" => $danru,
            "otp" => $otp
        ];

        $resultUpdate = $this->authService->updateAuthAcces($id, $data);

        if ($resultUpdate == 0) {
            http_response_code(400);
            echo json_encode(array(
                'status' => 'failed',
                'message' => 'no update access'
            ), JSON_PRETTY_PRINT);
            return;
        }

        http_response_code(200);
        echo json_encode(array(
            'status' => 'success',
            'message' => 'success update access'
        ), JSON_PRETTY_PRINT);
        return;
    }

    public function authView()
    {
        // dapatkan semua auth service
        $data = $this->authService->getAuth();
        View::render('layouts/app', 'authorization/auth', $data);
    }

    public function addAuthView()
    {
        View::render('layouts/app', 'authorization/add_auth');
    }
}
