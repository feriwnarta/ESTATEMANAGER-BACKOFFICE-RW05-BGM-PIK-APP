<?php

namespace NextG\RwAdminApp\Controllers;

use NextG\RwAdminApp\App\View;

use NextG\RwAdminApp\Services\WablasServices\Impl\WablasServiceImpl;
use NextG\RwAdminApp\Services\WablasServices\WablasService;

class OtpController
{

    private WablasService $wablasService;

    public function __construct()
    {
        $this->wablasService = new WablasServiceImpl;
    }


    public function otpView()
    {

        $barcode = $this->wablasService->deviceScan();
        $realtimeData = $this->wablasService->reportRealtime();
        $active = $this->wablasService->checkDeviceActive();
        $realtimeData = $realtimeData['data'];


        $data = [
            'realtimeData' => $realtimeData,
            'barcode' => $barcode,
            'status' => $active,
        ];
        View::render('layouts/app', 'otp/otp', $data);
    }
}
