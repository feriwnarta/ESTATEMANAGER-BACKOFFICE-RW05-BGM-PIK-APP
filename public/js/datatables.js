$(function () {
  if ($("#tableUser").length) {
    $("#tableUser").DataTable({
      searching: true,
      order: [[1, "DESC"]],
      paging: true,
      ordering: true,
      responsive: true,
      select: true,
    });
  }
});
