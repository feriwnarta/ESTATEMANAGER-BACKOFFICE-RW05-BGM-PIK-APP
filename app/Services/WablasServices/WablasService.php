<?php

namespace NextG\RwAdminApp\Services\WablasServices;

interface WablasService
{

    public function reportRealtime();
    public function checkDeviceActive();
    public function sendText($phoneNumber, $message);
    public function deviceScan();
    public function sendMultipleText($payload);
}
