<?php

namespace NextG\RwAdminApp\Controllers;

use NextG\RwAdminApp\App\View;
use NextG\RwAdminApp\Services\PaymentIplServices\Impl\PaymenIplServiceImpl;
use NextG\RwAdminApp\Services\PaymentIplServices\PaymentIplService;

class PaymentIplController
{

    private PaymentIplService $paymentIplService;

    /**
     * @param PaymentIplService $paymentIplService
     */
    public function __construct()
    {
        $this->paymentIplService = new PaymenIplServiceImpl();
    }


    public function index() {
        $result = $this->paymentIplService->getData();

        View::render('layouts/app', 'payment-ipl/payment', $result);

    }

    public function updatePayment() {
        // json data
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        if(!isset($obj['id']) || !isset($obj['status'])) {
            echo  json_encode('data kosong');
            return;
        }

        $id = $obj['id'];
        $status = $obj['status'];

        $this->paymentIplService->update($id, $status);



    }

}