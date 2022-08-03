$(document).ready(function () {
    $("#datatable").DataTable({
        "iDisplayLength": 20,
        "LengthMenu": [[20, 40, 60, 100, -1], [20, 40, 60, 100, "ВСЕ"]],
        "aLengthMenu": [[20, 40, 60, 100, -1], [20, 40, 60, 100, "ВСЕ"]]
    }), $("#datatable-buttons").DataTable({
        lengthChange: !1,
        buttons: ["copy", "excel", {
            extend: 'pdfHtml5',
            orientation: 'landscape',
            pageSize: 'A4'
        }, 'print', "colvis",]
    }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)")
});
$('.dataTables_filter input').attr('placeholder', 'Поиск');
