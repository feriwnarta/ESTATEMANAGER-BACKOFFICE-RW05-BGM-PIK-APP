var selectedOption = null;

$(function () {
  // ajax loading

  buttonUserDeleteClicked(".btn-user-delete");
  updateUser();
});

function setUpdate() {
  let idUser = $(".modal-body #idUser").val();
  let username = $(".modal-body #iplOrUsername").val();
  let email = $(".modal-body #email").val();
  let name = $(".modal-body #name").val();
  let phoneNumber = $(".modal-body #phoneNumber").val();
  let idAuth = selectedOption.attr("id");

  let data = JSON.stringify({
    username: username,
    email: email,
    name: name,
    no_telp: phoneNumber,
    id_user: idUser,
    id_auth: idAuth,
  });

  requestUpdateUser(data);
}

function requestUpdateUser(data) {
  swalfireDestroy();

  $.ajax({
    type: "POST",
    url: "update-user",
    data: data,
    dataType: "JSON",
    success: function (response) {

      if (response.message == "succes update user") {
        // error jika data post kosong
        Swal.fire({
          icon: "success",
          title: "Berhasil update user",
          showConfirmButton: true,
          didClose: () => {
            location.reload();
          },
        });
      }
    },
    error: function (xhr, status, error) {
      let message = JSON.parse(xhr.responseText).message;

      if (message == "parameter empty") {
        // error jika data post kosong
        Swal.fire({
          icon: "error",
          title: "Gagal update user",
          text: "Parameter yang dikirim kosong, hubungi administrator",
          showConfirmButton: true,
          didClose: () => {
            location.reload();
          },
        });
      } else if (message == 'failed update') {
         // error query update
         Swal.fire({
          icon: "error",
          title: "Gagal update user",
          text: "hubungi administrator",
          showConfirmButton: true,
          didClose: () => {
            location.reload();
          },
        });
      }
    },
  });
}

function swalfireDestroy() {
  // Hapus SweetAlert dari DOM
  $(".swal2-container").remove();

  // Hapus event terkait SweetAlert
  $(document).off("click", ".swal2-confirm");
}

function updateUser() {
  $(".btn-user-update").click(function () {
    let id = $(this).attr("id");

    let data = JSON.stringify({ id_user: id });

    getSingleUser(data);
  });
}

function getSingleUser(data) {
  $.ajax({
    type: "POST",
    url: "user",
    data: data,
    dataType: "JSON",
    success: function (response) {
      swalfireDestroy();

      $("#modalEditUser").modal("show");
      if (response.status == "success") {
        let user = response.data.user;
        let status = response.data.status;

        let option = "";

        // data option
        status.forEach((element) => {
          if (element.id_auth != user.id_auth) {
            option += `
            <option id="${element.id_auth}">${element.status}</option>
          `;
          }
        });

        // update modal
        let body = `
        <div class="data-user-edit">
          <input type="text" class="form-control hidden-input" id="idUser" readonly value="${user.id_user}">
          
          <div class="mb-3">
            <label for="iplOrUsername" class="form-label">Nomor Ipl / Username </label>
            <input type="email" class="form-control" id="iplOrUsername" value="${user.username}" >
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" value="${user.email}" >
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name" value="${user.name}" >
          </div>
          <div class="mb-3">
            <label for="phoneNumber" class="form-label">Nomor Telpon </label>
            <input type="number" class="form-control" id="phoneNumber" value="${user.no_telp}" >
          </div>

          <div class="mb-3">
          <label for="statusSelect" class="form-label">Status Akun</label>
            <select class="form-select" id="statusSelect" aria-label="Default select example">
              <option id="${user.id_auth}" selected>${user.status}</option>
                ${option}
            </select>
          </div>
        </div>
        `;

        $("#modalEditUser .modal-body").html(body);

        changeSelectStatus();
      }
    },
    error: function (xhr, status, error) {
      Swal.fire({
        icon: "error",
        title: "Gagal tampilkan detail",
        text: "hubungi administrator",
        showConfirmButton: true,
        didClose: () => {
          location.reload();
        },
      });
    },
  });
}

function changeSelectStatus() {
  selectedOption = $(".modal-body").find("option:selected");

  $("#statusSelect").change(function () {
    selectedOption = $(this).find("option:selected");
  });
}

function detailUser() {
  $("#tableUser td").click(function () {});
}

function initReplace(element) {
  let txtArea = $(`${element}`).text();

  let replacedHTML = txtArea.replace(regex, function (match, keyword) {
    let check = availableFormat(match);

    if (check) {
      return `
          <span class="badge rounded-pill text-bg-primary me-1" contenteditable="false">${match}</span>
          `;
    }
    return match;
  });

  $(`${element}`).html(replacedHTML);
}

// ajax loading
let ajaxStart = $(document).ajaxStart(function () {
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

/**
 * fungsi yang dijalankan saat button delete user diklik
 * @param {} tag
 */
let buttonUserDeleteClicked = function (tag) {
  $(`${tag}`).click(function () {
    // dapatkan id
    let id = $(this).attr("id");

    // data json
    let data = JSON.stringify({
      id_user: id,
    });

    Swal.fire({
      title: "Anda yakin menghapus data ini ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Batal",
      confirmButtonText: "Hapus",
    }).then((result) => {
      if (result.isConfirmed) {
        ajaxDeleteUser(data);
      }
    });
  });
};

let ajaxDeleteUser = function (data) {
  $.ajax({
    type: "POST",
    url: "delete-user",
    data: data,
    dataType: "JSON",

    success: function (response) {
      if (response.message == "success delete user") {
        Swal.fire({
          title: "Berhasil hapus user",
          icon: "success",
          didClose: () => {
            location.reload();
          },
        });
      }
    },

    error: function (xhr, status, error) {
      let message = JSON.parse(xhr.responseText).message;

      if (message == "parameter empty") {
        // error jika data post kosong
        Swal.fire({
          icon: "error",
          title: "Gagal hapus user",
          text: "Parameter yang dikirim kosong, hubungi administrator",
          showConfirmButton: true,
          didClose: () => {
            location.reload();
          },
        });
      } else if (message == "delete failed") {
        // error jika id tidak ketemu
        Swal.fire({
          icon: "error",
          title: "Gagal hapus user",
          text: "Parameter tidak sesuai, hubungi administrator",
          showConfirmButton: true,
          didClose: () => {
            location.reload();
          },
        });
      }
    },
  });
};
