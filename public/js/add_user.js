const formEmployee = `
<form action="POST" id="formAddEmployee" class="position-relative">
<div class="form-floating mb-3">
    <input type="text" id="inputUsername" class="form-control"  placeholder="username" required>
    <label for="floatingInput">Username</label>
</div>
<div class="form-floating mb-3">
    <input type="text" id="inputNama" class="form-control"  placeholder="nama" required>
    <label for="floatingPassword">Nama</label>
</div>
<div class="form-floating mb-3">
    <input type="email" id="inputEmail" class="form-control" placeholder="email" required>
    <label for="floatingPassword">Email</label>
</div>
<div class="form-floating mb-3">
    <input type="number" class="form-control" id="inputNomorTelpon" placeholder="Nomor telpon" required>
    <label for="floatingNumber">Nomor Telpon</label>
</div>

<div class="form-floating mb-3">
  <select class="form-select" id="bagianSelect" aria-label="Floating label select example">
  <option selected>Pilih Bagian</option>
  </select>
  <label for="floatingSelect">Bagian</label>
</div>
<div class="form-floating mb-3">
    <input type="password" class="form-control" id="inputPassword" placeholder="Password" required>
    <label for="floatingPassword">Password</label>
</div>
<button type="submit" class="btn btn-primary position-absolute end-0">Simpan</button>
</form>
`;

let idRadio = null;

$(function () {
  setRadio();
  $(".form-content").html(formEmployee);
  positionRequestLandscape();
  idRadio = "radioPerawatanLanskap";
  sweetAlertDestroy();
  buttonSaveClick();
});

$(document).ajaxStart(function () {
  Swal.fire({
    html: `
    <div style="display: flex; justify-content: center; align-items: center; height: 100px;">
    <div style="width: 3rem; height: 3rem;" class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
  
    `,
    showCancelButton: false,
    showConfirmButton: false,
    allowOutsideClick: false,
    allowEscapeKey: false,
    customClass: {
      popup: "swal-custom-popup",
      content: "swal-custom-content",
    },
    onOpen: () => {
      document.getElementsByClassName("swal-custom-popup")[0].style.overflowY =
        "auto";
      document.getElementsByClassName("swal-custom-content")[0].style.height =
        "auto";
    },
    onBeforeOpen: () => {
      Swal.showLoading();
    },
  });
});



function buttonSaveClick() {
  $("#formAddEmployee").submit(function (e) {
    e.preventDefault();

    let username = $("#inputUsername").val();
    let nama = $("#inputNama").val();
    let email = $("#inputEmail").val();
    let nomorTelpon = $("#inputNomorTelpon").val();
    let bagian = $("#bagianSelect").val();

    let password = $("#inputPassword").val();

    if (bagian == "Pilih Bagian") {
      Swal.fire({
        icon: "error",
        title: "Bagian harus dipilih",
        showConfirmButton: true,
      });
    }

    let jsonData = JSON.stringify({
      username: username,
      name: nama,
      email: email,
      phoneNumber: nomorTelpon,
      bagian: bagian,
      password: password,
      divisi: idRadio,
    });

    saveUserRequest(jsonData);
  });
}

function saveUserRequest(data) {
  $.ajax({
    type: "POST",
    url: "save-employee",
    data: data,
    dataType: "JSON",
    success: function (response) {
      sweetAlertDestroy();


      if ((response.message = "success create user")) {
        Swal.fire({
          icon: "success",
          title: "Berhasil tambah user",
          showConfirmButton: true,

          didClose: () => {
            location.reload();
          },
        });
      }
    },
    error: function (xhr, status, error) {
      let message = JSON.parse(xhr.responseText).message;
      if (message == "position not exist") {
        Swal.fire({
          icon: "error",
          title: "Posisi tidak tersedia untuk bagian ini",
          message: "silahkan hubungi administrator",
          showConfirmButton: true,
          didClose: () => {
            location.reload();
          },
        });
      } else if (message == "division not exist") {
        Swal.fire({
          icon: "error",
          title: "divisi tidak tersedia untuk bagian ini",
          text: "silahkan hubungi administrator",
          showConfirmButton: true,
          didClose: () => {
            location.reload();
          },
        });
      } else if (message == "id master not exist") {
        Swal.fire({
          icon: "error",
          title: "Ada sesuatu yang bermasalah",
          text: "silahkan hubungi administrator",
          showConfirmButton: true,
          didClose: () => {
            location.reload();
          },
        });
      } else if (message == "position not exist") {
        Swal.fire({
          icon: "error",
          title: "Bagian tidak tersedia",
          text: "silahkan hubungi administrator",
          showConfirmButton: true,
          didClose: () => {
            location.reload();
          },
        });
      } else if (message == "auth not exist") {
        Swal.fire({
          icon: "error",
          title: "Authentikasi tidak tersedia untuk bagian ini",
          text: "silahkan hubungi administrator",
          showConfirmButton: true,
          didClose: () => {
            location.reload();
          },
        });
      } else if (message == "username or email or phone number exist") {
        Swal.fire({
          icon: "error",
          title: "Duplikat data",
          text: "Username atau email atau nomor telpon tidak boleh sama",
          showConfirmButton: true,
          didClose: () => {
            location.reload();
          },
        });
      } else if (message == "failed save user") {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Ada sesuatu yang salah, hubungi administrator",
          showConfirmButton: true,
          didClose: () => {
            location.reload();
          },
        });
      } else if (message == "failed save notification") {
        Swal.fire({
          icon: "error",
          title: "Gagal menyimpan notifikasi",
          text: "Ada sesuatu yang salah, hubungi administrator",
          showConfirmButton: true,
          didClose: () => {
            location.reload();
          },
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Ada sesuatu yang salah, hubungi administrator",
          showConfirmButton: true,
          didClose: () => {
            location.reload();
          },
        });
      }
    },
  });
}

function setRadio() {
  // Event delegation untuk mendeteksi perubahan pada radio button dengan kelas "form-check-input"
  $(document).on("change", ".form-check-input", function () {
    // Cek apakah radio button diaktifkan (checked)
    if ($(this).is(":checked")) {
      idRadio = $(this).attr("id");
      changeForm(idRadio);
    }
    $(".form-check-input").not(this).prop("checked", false);
  });
}

function changeForm(id) {
  if (id === "radioPerawatanLanskap") {
    // $(".form-content").html(formEmployee);
    positionRequestLandscape();
  } else if (id === "radioMekanikelElektrikel") {
    // $(".form-content").html(formEmployee);
    positionRequestMekanikelElektrikel();
  } else if (id === "radioBuildingControll") {
    // $(".form-content").html(formEmployee);
    positionRequestBuildingControll();
  } else if (id === "radioMasalahkemanan") {
    // $(".form-content").html(formEmployee);
    positionRequestSecurity();
  }
}

function positionRequestSecurity() {
  $.ajax({
    type: "GET",
    url: "position-security",

    success: function (response) {
      if (response !== undefined && response !== null) {
        let position = JSON.parse(response);

        let option = "";

        position.forEach((position) => {
          option += `
          <option value='${position.id_position}'>${position.position}</option>
          `;
        });

        $("#bagianSelect").empty();
        $("#bagianSelect").append(option);
        sweetAlertDestroy();
      }
    },
  });
}

function positionRequestBuildingControll() {
  $.ajax({
    type: "GET",
    url: "position-building-controll",

    success: function (response) {
      if (response !== undefined && response !== null) {
        let position = JSON.parse(response);

        let option = "";

        position.forEach((position) => {
          option += `
          <option value='${position.id_position}'>${position.position}</option>
          `;
        });

        $("#bagianSelect").empty();
        $("#bagianSelect").append(option);
        sweetAlertDestroy();
      }
    },
  });
}

function positionRequestMekanikelElektrikel() {
  $.ajax({
    type: "GET",
    url: "position-me",

    success: function (response) {
      if (response !== undefined && response !== null) {
        let position = JSON.parse(response);

        let option = "";

        position.forEach((position) => {
          option += `
          <option value='${position.id_position}'>${position.position}</option>
          `;
        });

        $("#bagianSelect").empty();
        $("#bagianSelect").append(option);
        sweetAlertDestroy();
      }
    },
  });
}

function positionRequestMekanikelElektrikel() {
  $.ajax({
    type: "GET",
    url: "position-me",

    success: function (response) {
      if (response !== undefined && response !== null) {
        let position = JSON.parse(response);

        let option = "";

        position.forEach((position) => {
          option += `
          <option value='${position.id_position}'>${position.position}</option>
          `;
        });

        $("#bagianSelect").empty();
        $("#bagianSelect").append(option);
        sweetAlertDestroy();
      }
    },
  });
}

function positionRequestLandscape() {
  $.ajax({
    type: "GET",
    url: "position-landscape",

    success: function (response) {
      if (response !== undefined && response !== null) {
        let position = JSON.parse(response);

        let option = "";

        position.forEach((position) => {
          option += `
          <option value='${position.id_position}'>${position.position}</option>
          `;
        });
        $("#bagianSelect").empty();
        $("#bagianSelect").append(option);
        sweetAlertDestroy();
      }
    },
  });
}
