<?php

namespace NextG\RwAdminApp\Services\PaymentIplServices;

interface PaymentIplService
{

    public function getData();
    public function update(string $id, string $status, string $note, array $file);
    public function saveNotif(string $idUser, string $message);
}
