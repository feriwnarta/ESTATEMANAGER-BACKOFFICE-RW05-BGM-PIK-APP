<?php

use NextG\RwAdminApp\App\Configuration;

if ($data == null) {
    echo 'data kosong';
    die();
}

$tableHeader =
    <<<EOD

<table id="tableUser" class="ui celled table ">
<thead>
    <tr>
        <th>Username</th>
        <th>Name</th>
        <th>Email</th>
        <th>No Telp</th>
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

// tampilakan isi data user
foreach ($data as $user) {

    $id = $user->getIdUser();
    $userName =  $user->getUserName();
    $email =  $user->getEmail();
    $noTelp = $user->getNoTelp();
    $name = $user->getName();
    $profileImage = $user->getProfileImage();

    $tableData .=
        <<<EOD
        <tr id="$id">
            <td>$name</td>
            <td>$userName</td>
            <td>$email</td>
            <td>$noTelp</td>
            <td style="width: 70px;">
            <button type="button" class="btn btn-danger" id="" data-bs-toggle="modal" data-bs-target="">Hapus</button>
            </td>
        </tr>
    EOD;
}

// format table 
$tableDisplay = $tableHeader . $tableData . $tableFooter;


// cetak tabel
echo $tableDisplay;


// ambil script data table
echo '<script src="public/js/datatables.js"></script>';
