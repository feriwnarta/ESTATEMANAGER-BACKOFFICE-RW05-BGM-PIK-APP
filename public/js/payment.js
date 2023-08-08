$(function() {
    btnUpdateOnClick();

    if ($("#tableUser").length) {
        $("#tableUser").DataTable({
            "drawCallback": function( settings ) {
                btnUpdateOnClick();

            },
            searching: true,
            order: [[1, "DESC"]],
            paging: true,
            ordering: true,
            responsive: true,
            select: true,
        });
    }
});

let isFormProcessing = false;

function btnUpdateOnClick() {
    $('.btn-ipl-update').click(function () {
        showModal();

        let parent = $(this).closest('tr');

        let status = $(parent).find('#status').html();
        let id = $(this).attr('id');



        let allStatus = selectstatus(status);


        $('.modal-body').html(allStatus);
        formSelectUpdate();

        setUpdatePayment(id);

    });
}

function formSelectUpdate() {
    $('.form-select').on('change', function () {
        let input = '<div class="forms mt-2">\n' +
            '  <label for="inputNote" class="form-label">Catatan Penolakan</label>' +
            '  <textarea type="text" class="form-control" id="inputNote" rows="5">Foto yang anda kirimkan tidak jelas dan buram, silahkan kirim kembali untuk bisa mengambil kantong sampah</textarea>\n' +
            '</div>';

        let val = $(this).val();

        if(val == 'Diterima') {
            input = '<div class="forms mt-2">\n' +
                '  <label for="inputNote" class="form-label">Catatan Diterima</label>' +
                '  <textarea class="form-control" id="inputNote"  rows="5">Bukti Pembayaran anda diterima. silahkan datang ke kantor RW 05 BGM PIK untuk mengambil kantong sampah </textarea> \n' +
                '</div>';
        } else if (val == 'Diproses') {
            input = '<div class="forms mt-2">\n' +
                '  <label for="inputNote" class="form-label">Catatan Diproses</label>' +
                ' <textarea class="form-control" id="inputNote" rows="5">Bukti Pembayaran anda sedang diproses. Tunggu notifikasi selanjutnya untuk informasi mengambil kantong sampah di kantor RW 05 </textarea>\n' +

                '</div>';
        } else if(val == 'Ditolak') {
            input = '<div class="forms mt-2">\n' +
                '  <label for="inputNote" class="form-label">Catatan Penolakan</label>' +
                '  <textarea type="text" class="form-control" id="inputNote" rows="5">Foto yang anda kirimkan tidak jelas dan buram, silahkan kirim kembali untuk bisa mengambil kantong sampah</textarea>\n' +
                '</div>';
        }

        $('.forms').remove();

        $('.modal-body').append(input);

    });
}



function selectstatus(status) {
    if(status == 'Ditolak') {
        let input = '<div class="forms mt-2">\n' +
            '  <label for="inputNote" class="form-label">Catatan Penolakan</label>' +
            '  <textarea type="text" class="form-control" id="inputNote" rows="5">Foto yang anda kirimkan tidak jelas dan buram, silahkan kirim kembali untuk bisa mengambil kantong sampah</textarea>\n' +
            '</div>';

        return `
    <select class="form-select">
              <option selected> ${status}</option>
              <option>Diproses</option>
              <option >Diterima</option>
            </select>
    ` + input;
    } else if (status == 'Diterima') {
        let input = '<div class="forms mt-2">\n' +
            '  <label for="inputNote" class="form-label">Catatan Diterima</label>' +
            '  <textarea class="form-control" id="inputNote"  rows="5">Bukti Pembayaran anda diterima. silahkan datang ke kantor RW 05 BGM PIK untuk mengambil kantong sampah </textarea> \n' +
            '</div>';

        return  `<select class="form form-select">
              <option selected> ${status}</option>
              <option>Diproses</option>
              <option >Ditolak</option>
            </select>` + input;
    } else if (status == 'Diproses') {

        let input = '<div class="forms mt-2">\n' +
            '  <label for="inputNote" class="form-label">Catatan Diproses</label>' +
            ' <textarea class="form-control" id="inputNote" rows="5">Bukti Pembayaran anda sedang diproses. Tunggu notifikasi selanjutnya untuk informasi mengambil kantong sampah di kantor RW 05 </textarea>\n' +

            '</div>';

        return  `<select class="form-select">
              <option selected> ${status}</option>
              <option>Diterima</option>
              <option >Ditolak</option>
            </select>` + input;
    }


}

function setUpdatePayment(id) {
    $('#updatePayment').click(function () {

        let status = $('.form-select').val();
        let note = $('#inputNote').val();


        let jsonData = JSON.stringify({
            "id" : id,
            "status" : status,
            'note' : note
        });


        requestUpdateAccess(jsonData);
    });
}

function requestUpdateAccess(data) {
    if (isFormProcessing) {
        return; // Cegah pengiriman formulir jika sudah sedang diproses
    }

    isFormProcessing = true;

    $.ajax({
        type: "POST",
        url: "update-payment",
        data: data,
        dataType: "JSON",
        success: function (response) {
            sweetAlertDestroy();

            isFormProcessing = false;

            if(response.message == "berhasil update status") {
                showSweetAlert(true, 'success', 'Berhasil update payment')
                return;
            }



        },
        error: function (xhr, status, error) {
            sweetAlertDestroy();
            isFormProcessing = false;
            let message = JSON.parse(xhr.responseText).message;

            if(message == 'gagal update status') {
                showSweetAlert(true, 'error', 'Gagal update payment, silahkan hubungin admin')
            }


        },
    });
}



function showModal() {
    $("#modalUpdatePay").modal("show");
}