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
        <th>Warga</th>
        <th>Management</th>
        <th>Estate Manager</th>
        <th>Manager Kontraktor</th>
        <th>Kepala Kontraktor</th>
        <th>Kordinator Lapangan</th>
        <th>Danru</th>
        <th>OTP</th>
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
foreach ($data as $auth) {



    // $tableData .= <<<EOD
    // <tr id="{$auth['id_auth']}">
    //     <td>{$auth['status']}</td>
    //     <td>
    //         <input class="form-check-input" type="checkbox" {$auth['status'] ==  'some_value'} ? {'checked' : 'disabled'}>
    //     </td>
    // </tr>
    // EOD;

    $tableData .= "<tr id='{$auth['id_auth']}'>
    <td>{$auth['status']}</td>
    <td> 
        <input class='form-check-input' id='warga' type='checkbox'" . ($auth['warga'] == 1 ? "checked" : "") . " disabled>
    </td>
    <td>
        <input class='form-check-input' id='management' type='checkbox'" . ($auth['management'] == 1 ? "checked" : "") . " disabled>
    </td>
    <td>
        <input class='form-check-input' id='estate_manager' type='checkbox'" . ($auth['estate_manager'] == 1 ? "checked" : "") . " disabled>
    </td>
    <td>
        <input class='form-check-input' id='manager_kontraktor' type='checkbox'" . ($auth['manager_kontraktor'] == 1 ? "checked" : "") . " disabled>
    </td>
    <td>
        <input class='form-check-input' id='kepala_kontraktor' type='checkbox'" . ($auth['kepala_contractor'] == 1 ? "checked" : "") . " disabled>
    </td>
    <td>
        <input class='form-check-input' id='kordinator_lapangan' type='checkbox'" . ($auth['cordinator'] == 1 ? "checked" : "") . " disabled>
    </td>
   
    <td>
        <input class='form-check-input' id='danru' type='checkbox'" . ($auth['danru'] == 1 ? "checked" : "") . " disabled>
    </td>
    <td>
        <input class='form-check-input' id='otp' type='checkbox'" . ($auth['otp'] == 1 ? "checked" : "") . " disabled>
    </td>
    <td>
        <button type='button' class='btn btn-primary btn-auth-update'>Update</button>
    </td>
    
    </tr>";
}

// format table 
$tableDisplay = $tableHeader . $tableData . $tableFooter;


// cetak tabel
echo $tableDisplay;

// $modal = <<<EOD
// <!-- Modal -->
// <div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
//     <div class="modal-dialog ">
//         <div class="modal-content">
//             <div class="modal-header">
//                 <h1 class="modal-title fs-5" id="exampleModalLabel">Update User</h1>
//                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
//             </div>
//             <div class="modal-body">

//             </div>
//             <div class="modal-footer">
//                 <button type="button" class="btn btn-primary" id="updateMenu" data-bs-dismiss="modal" onclick="setUpdate()">Update</button>
//             </div>
//         </div>
//     </div>
// </div>
// EOD;

// echo $modal;

// ambil script data table
echo '<script src="public/js/datatables.js"></script>';
echo '<script src="public/js/auth.js"></script>';
