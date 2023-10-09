$(function () {
  btnUpdateOnClick();

  if ($("#tableUser").length) {
    $("#tableUser").DataTable({
      drawCallback: function (settings) {
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
let deliveryProof;

function btnUpdateOnClick() {
  $(".btn-ipl-update").click(function () {
    showModal();

    let parent = $(this).closest("tr");

    let status = $(parent).find("#status").html();
    let id = $(this).attr("id");

    let allStatus = selectstatus(status);

    $(".modal-body").html(allStatus);
    formSelectUpdate();

    setUpdatePayment(id);
  });
}

function formSelectUpdate() {
  $(".form-select").on("change", function () {
    let input =
      '<div class="forms mt-2">\n' +
      '  <label for="inputNote" class="form-label">Catatan Penolakan</label>' +
      '  <textarea type="text" class="form-control" id="inputNote" rows="5">Foto yang anda kirimkan tidak jelas dan buram, silahkan kirim kembali untuk bisa mengambil kantong sampah</textarea>\n' +
      "</div>";

    let val = $(this).val();

    if (val == "Dikirim") {
      input =
        '<div class="forms mt-2">' +
        '<label for="imagePicker">Upload Bukti Pengiriman : </label>' +
        "<br>" +
        '<input type="file" class="form-control-file" id="imagePicker">' +
        "</div>" +
        '<div class="forms mt-2">\n' +
        '  <label for="inputNote" class="form-label">Catatan Dikirim</label>' +
        '  <textarea class="form-control" id="inputNote"  rows="5">Kantong sampah terkirim</textarea> \n' +
        "</div>";
    } else if (val == "Diproses") {
      input =
        '<div class="forms mt-2">\n' +
        '  <label for="inputNote" class="form-label">Catatan Diproses</label>' +
        ' <textarea class="form-control" id="inputNote" rows="5">Bukti Pembayaran anda sedang diproses. Tunggu notifikasi selanjutnya kami akan segera melakukan pengiriman kantong plastik</textarea>\n' +
        "</div>";
    } else if (val == "Ditolak") {
      input =
        '<div class="forms mt-2">\n' +
        '  <label for="inputNote" class="form-label">Catatan Penolakan</label>' +
        '  <textarea type="text" class="form-control" id="inputNote" rows="5">Foto yang anda kirimkan tidak jelas dan buram, silahkan kirim kembali untuk bisa mengambil kantong sampah</textarea>\n' +
        "</div>";
    }

    $(".forms").remove();

    $(".modal-body").append(input);

    if (val == "Dikirim") {
      selectDeliveryProof();
    }
  });
}

function selectDeliveryProof() {
  $("#imagePicker").change(function () {
    deliveryProof = this.files[0]; // Mendapatkan file yang dipilih
  });
}

function selectstatus(status) {
  if (status == "Ditolak") {
    let input =
      '<div class="forms mt-2">\n' +
      '  <label for="inputNote" class="form-label">Catatan Penolakan</label>' +
      '  <textarea type="text" class="form-control" id="inputNote" rows="5">Foto yang anda kirimkan tidak jelas dan buram, silahkan kirim kembali untuk bisa mengambil kantong sampah</textarea>\n' +
      "</div>";

    return (
      `
    <select class="form-select">
              <option selected> ${status}</option>
              <option>Diproses</option>
              <option >Dikirim</option>
            </select>
    ` + input
    );
  } else if (status == "Dikirim") {
    let input =
      '<div class="forms mt-2">\n' +
      '  <label for="inputNote" class="form-label">Catatan Dikirim</label>' +
      '  <textarea class="form-control" id="inputNote"  rows="5">Kantong sampah terkirim</textarea> \n' +
      "</div>";

    return (
      `<select class="form form-select">
              <option selected> ${status}</option>
              <option>Diproses</option>
              <option >Ditolak</option>
            </select>` + input
    );
  } else if (status == "Diproses") {
    let input =
      '<div class="forms mt-2">\n' +
      '  <label for="inputNote" class="form-label">Catatan Diproses</label>' +
      ' <textarea class="form-control" id="inputNote" rows="5">Bukti Pembayaran anda sedang diproses. Tunggu notifikasi selanjutnya kami akan segera melakukan pengiriman kantong plastik </textarea>\n' +
      "</div>";

    return (
      `<select class="form-select">
              <option selected> ${status}</option>
              <option>Dikirim</option>
              <option >Ditolak</option>
            </select>` + input
    );
  }
}
// Buat objek FormData secara manual
var formData = new FormData();

function setUpdatePayment(id) {
  $("#updatePayment").click(function () {
    let status = $(".form-select").val();
    let note = $("#inputNote").val();

    if (status == "Dikirim" && deliveryProof == undefined) {
      showSweetAlert(true, "error", "Harap upload bukti pengiriman");
      return;
    }

    let jsonData = JSON.stringify({
      id: id,
      status: status,
      note: note,
    });

    // Tambahkan data ke FormData
    formData.append("id", id);
    formData.append("status", status);
    formData.append("note", note);
    formData.append("file", deliveryProof);

    requestUpdateAccess(formData);
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
    processData: false, // Jangan proses data
    contentType: false, // Tidak mengatur tipe konten
    success: function (response) {
      console.log(response);
      response = JSON.parse(response);

      sweetAlertDestroy();

      isFormProcessing = false;

      if (response.message == "Berhasil memperbarui status") {
        showSweetAlert(true, "success", "Berhasil update payment");
        return;
      }
    },
    error: function (xhr, status, error) {
      sweetAlertDestroy();
      isFormProcessing = false;

      let errorResponse = JSON.parse(xhr.responseText);

      showSweetAlert(true, "error", errorResponse.message);
    },
  });
}

function showModal() {
  $("#modalUpdatePay").modal("show");
}
