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

function sweetAlertDestroy() {
    // Menutup SweetAlert menggunakan fungsi close()
    Swal.close();
}

function showSweetAlert(isReload = true, icon, title, text = '' ){
    Swal.fire({
        icon: icon,
        title: title,
        text : text,
        showConfirmButton: true,

        didClose: (isReload) ? () => {
            location.reload();
        } : null,
    });
}

