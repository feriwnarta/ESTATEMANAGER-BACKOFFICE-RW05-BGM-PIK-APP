$(function () {

  if ($("#tableUser").length) {
    $("#tableUser").DataTable({
      "drawCallback": function( settings ) {

        buttonUpdateClicked();

      },
      searching: true,
      order: [[1, "DESC"]],
      paging: true,
      ordering: true,
      responsive: true,
      select: true,
    });
  }

  buttonUpdateClicked();

});

function buttonUpdateClicked() {
  $(".btn-auth-update").on("click", function () {
    // Ambil elemen tr (baris) yang sejajar dengan tombol
    var row = $(this).closest("tr");

    // Cari semua input checkbox dalam elemen tr tersebut dan hapus atribut "disabled"
    row.find("input[type='checkbox']").removeAttr("disabled");

    // Ubah tulisan tombol menjadi "Save"
    $(this).text("Save");

    // Ubah class tombol dari "btn-primary" menjadi "btn-success"
    $(this)
      .removeClass("btn-primary")
      .addClass("btn-success")
      .removeClass("btn-auth-update")
      .addClass("btn-auth-save");
    buttonAuthSaveClicked();
  });
}



function buttonAuthSaveClicked() {
  $(".btn-auth-save").on("click", function () {
    // Objek untuk menyimpan pasangan key dan value
    var checkboxValues = {};

    // Ambil semua input checkbox dalam elemen tr tersebut
    $(this)
      .closest("tr")
      .find("input[type='checkbox']")
      .each(function () {
        var key = $(this).attr("id"); // Ambil nilai "id" sebagai key
        var value = this.checked ? 1 : 0; // Ubah nilai true menjadi 1 dan false menjadi 0
        checkboxValues[key] = value; // Tambahkan pasangan key dan value ke objek
      });

    // Ambil id dari tag tr (baris) tersebut
    var idAuth = $(this).closest("tr").attr("id");

    let jsonData = JSON.stringify({
      id_auth: idAuth,
      access: checkboxValues,
    });

    requestUpdateAccess(jsonData);
  });
}

function requestUpdateAccess(data) {
  $.ajax({
    type: "POST",
    url: "update-auth",
    data: data,
    dataType: "JSON",
    success: function (response) {

      sweetAlertDestroy();

      if (response.message == "success update access") {
        Swal.fire({
          icon: "success",
          title: "Berhasil update akses",
          showConfirmButton: true,

          didClose: () => {
            location.reload();
          },
        });
      }
    },
    error: function (xhr, status, error) {
      sweetAlertDestroy();

      let message = JSON.parse(xhr.responseText).message;
      if (message == "failed update access") {
        Swal.fire({
          icon: "warning",
          title: "Gagal update",
          message: "Tidak ada data yg terupdate",
          showConfirmButton: true,
          didClose: () => {
            location.reload();
          },
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Gagal update",
          message: "Ada sesuatu yang salah, silahkan hubungi admin",
          showConfirmButton: true,
          didClose: () => {
            location.reload();
          },
        });
      }
    },
  });
}
