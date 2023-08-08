<?php

if ($data == null) {
    echo 'data kosong';
    die();
}

$tableHeader =
    <<<EOD

<table id="tableUser" class="ui celled table ">
<thead>
    <tr>
        <th>Status</th>
        <th>Username</th>
        <th>Name / Nomor IPL</th>
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
    $status = $user->getStatus();
    $email =  $user->getEmail();
    $noTelp = $user->getNoTelp();
    $name = $user->getName();
    $profileImage = $user->getProfileImage();

    $tableData .=
        <<<EOD
        <tr id="$id">
            <td>$status</td>
            <td>$userName</td>
            <td>$name</td>
            <td>$email</td>
            <td>$noTelp</td>
            <td style="width: 155px;">
            <button type="button" class="btn btn-primary btn-user-update" id="$id">Update</button>
            <button type="button" class="btn btn-danger btn-user-delete" id="$id">Hapus</button>
            </td>
        </tr>
    EOD;
}

// format table 
$tableDisplay = $tableHeader . $tableData . $tableFooter;


// cetak tabel
echo $tableDisplay;

$modal = <<<EOD
<!-- Modal -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="updateMenu" data-bs-dismiss="modal" onclick="setUpdate()">Update</button>
            </div>
        </div>
    </div>
</div>
EOD;

echo $modal;

// ambil script data table
echo '<script src="public/js/user.js"></script>';
