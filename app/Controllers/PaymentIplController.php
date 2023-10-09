<?php

namespace NextG\RwAdminApp\Controllers;

use NextG\RwAdminApp\App\View;
use NextG\RwAdminApp\Services\PaymentIplServices\Impl\PaymentIplServiceImpl;
use NextG\RwAdminApp\Services\PaymentIplServices\PaymentIplService;

class PaymentIplController
{

    private PaymentIplService $paymentIplService;

    /**
     * @param PaymentIplService $paymentIplService
     */
    public function __construct()
    {
        $this->paymentIplService = new PaymentIplServiceImpl();
    }


    public function index()
    {
        $result = $this->paymentIplService->getData();

        View::render('layouts/app', 'payment-ipl/payment', $result);
    }

    public function updatePayment()
    {

        if (!isset($_POST['id']) || !isset($_POST['status']) || !isset($_POST['note'])) {
            echo  json_encode('data kosong');
            return;
        }

        $id = $_POST['id'];
        $status = $_POST['status'];
        $note = $_POST['note'];
        $file = [];

        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
        }


        $this->paymentIplService->update($id, $status, $note, $file);
    }
}
