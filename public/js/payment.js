$(function() {
    btnUpdateOnClick();
});

function btnUpdateOnClick() {
    $('.btn-ipl-update').click(function () {
        showModal();

        let parent = $(this).closest('tr');

        let status = $(parent).find('#status').html();
        let id = $(this).attr('id');

        let allStatus = selectstatus(status);

        $('.modal-body').html(allStatus);

        setUpdatePayment(id);

    });
}

function selectstatus(status) {
    if(status == 'Ditolak') {
        return `
    <select class="form-select">
              <option selected> ${status}</option>
              <option>Diproses</option>
              <option >Diterima</option>
            </select>
    `;
    } else if (status == 'Diterima') {
        return `<select class="form-select">
              <option selected> ${status}</option>
              <option>Diproses</option>
              <option >Ditolak</option>
            </select>`;
    } else if (status == 'Diproses') {
        return `<select class="form-select">
              <option selected> ${status}</option>
              <option>Diterima</option>
              <option >Ditolak</option>
            </select>`;
    }


}

function setUpdatePayment(id) {
    $('#updatePayment').click(function () {

        let status = $('.form-select').val();

        let jsonData = JSON.stringify({
            "id" : id,
            "status" : status
        });


        requestUpdateAccess(jsonData);
    });
}

function requestUpdateAccess(data) {
    $.ajax({
        type: "POST",
        url: "update-payment",
        data: data,
        dataType: "JSON",
        success: function (response) {
            sweetAlertDestroy();

            if(response.message == "berhasil update status") {
                showSweetAlert(true, 'success', 'Berhasil update payment')
                return;
            }



        },
        error: function (xhr, status, error) {
            sweetAlertDestroy();
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