<?php

$root = \NextG\RwAdminApp\App\Configuration::$ROOT_APP;
$rootAdmin = \NextG\RwAdminApp\App\Configuration::$ROOT;

if ($data == 'data kosong') {
    echo $data;
    return;
}



$tableHeader =
    <<<EOD

<table id="tableUser" class="ui celled table ">
<thead>
    <tr>
        <th>No IPL</th>
        <th>Nama</th>
        <th>Bukti Pembayaran</th>
        <th>Bukti Pengiriman</th>
        <th>Periode</th>
        <th>Status</th>
        <th>Lokasi</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>

EOD;

$tableFooter =
    <<<EOD
</tbody>
</table>
EOD;

$tableData = '';

foreach ($data as $payment) {

    $id = $payment['id'];
    $noIpl = $payment['username'];
    $buktiPembayaran = $payment['image'];
    $buktiPengiriman = $payment['delivery_proof'];
    $name = $payment['name'];
    $periode = $payment['periode'];
    $status = $payment['status'];

    $latitude = $payment['latitude'];
    $longitude = $payment['longitude'];
    $apiMapsLoc = "https://www.google.com/maps/search/?api=1&query={$latitude},{$longitude}
    ";

    if ($buktiPengiriman != '') {

        $tableData .=
            <<<EOD
        <tr id="$id">
            <td>$noIpl</td>
            <td>$name</td>
            <td><a href="$root$buktiPembayaran" target="_blank">Bukti Pembayaran</a></td>
            <td><a href="$rootAdmin$buktiPengiriman" target="_blank">Bukti Pengiriman</a></td>
            <td>$periode</td>
            <td id="status">$status</td>
            <td><a href="$apiMapsLoc">Lokasi Pengiriman</a></td>
            <td style="width: 55px;">
                <button type="button" class="btn btn-primary btn-ipl-update" id="$id">Update</button>
            </td>
        </tr>
    EOD;
    } else {
        $tableData .=
            <<<EOD
    <tr id="$id">
        <td>$noIpl</td>
        <td>$name</td>
        <td><a href="$root$buktiPembayaran" target="_blank">Bukti Pembayaran</a></td>
        <td>Kantong sampah belum terkirim</td>
        <td>$periode</td>
        <td id="status">$status</td>
        <td><a href="$apiMapsLoc">Lokasi Pengiriman</a></td>
        <td style="width: 55px;">
            <button type="button" class="btn btn-primary btn-ipl-update" id="$id">Update</button>
        </td>
    </tr>
EOD;
    }
}

// format table
$tableDisplay = $tableHeader . $tableData . $tableFooter;

// cetak tabel
echo $tableDisplay;

$modal = <<<EOD
<!-- Modal -->
<div class="modal fade" id="modalUpdatePay" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Status Pembayaran</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="updatePayment" data-bs-dismiss="modal">Update</button>
            </div>
        </div>
    </div>
</div>
EOD;

echo $modal;

// ambil script data table
//echo '<script src="public/js/datatables.js"></script>';
echo '<script src="public/js/payment.js"></script>';
