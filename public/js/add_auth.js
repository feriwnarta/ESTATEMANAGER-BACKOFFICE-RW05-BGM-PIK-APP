$(function () {
    btnAuthSaveOnclick();
});


/**
 * saat button save auth diklik
 */
function btnAuthSaveOnclick() {
    $('#btnSaveAuth').on('click', function () {

        $("#formAddAuth").submit(function (e) {
            e.preventDefault();

            let access = [];
            $('.checkbox-access').find("input[type='checkbox']").each(function () {
                let id = this.checked ? $(this).attr('id') : null;
                if (id !== null) {
                    access.push(id);
                }
            });

            // jika tidak ada akses yang dipilih
            if (access.length == 0) {
                showSweetAlert(true, 'error', 'Harap pilih salah satu akses');
                return;
            }

            let status = $('#status').val();

            let jsonData = JSON.stringify(
                {
                    status: status,
                    access: access
                }
            );

            ajaxRequestSaveAccess(jsonData);

        });

    });
}


function ajaxRequestSaveAccess(data) {

    $.ajax({
        type: "POST",
        url: "add-auth",
        data: data,
        dataType: "JSON",
        success: function (response) {

            sweetAlertDestroy();

            if (response.message == 'success save auth') {
                showSweetAlert(true, 'success', 'Success', 'Berhasil tambah authorization baru');
            }

        },
        error: function (xhr, status, error) {
            sweetAlertDestroy();

            let message = JSON.parse(xhr.responseText).message;

            if (message == 'auth status exist') {
                showSweetAlert(true, 'error', 'Error', 'Status sudah tersedia, silahkan gunakan nama yang lain');
            } else if (message == 'failed save auth') {
                showSweetAlert(true, 'error', 'Error', 'Gagal menyimpan auth, hubungi administrator');
            } else {
                showSweetAlert(true, 'error', 'Error', 'Ada sesuatu yang salah hubungi administrator');
            }

        },
    });
}

