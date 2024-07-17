// Data Tabel
$(document).ready(function () {
    $('#example').DataTable({
        pageLength: 10,
        pagingType: 'full_numbers',
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
