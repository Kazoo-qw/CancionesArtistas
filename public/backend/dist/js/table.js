class CustomDataTable {
    constructor(id) {
        this.id = id;
        this.initializeDataTable();
    }

    initializeDataTable() {
        $(this.id).DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            language: {
                sLengthMenu: "Show _MENU_ entries",
                sEmptyTable: "No data available in table",
                sInfo: "Showing _START_ to _END_ of _TOTAL_ entries",
                sInfoEmpty: "Showing 0 to 0 of 0 entries",
                sSearch: "Search:",
                sZeroRecords: "No matching records found",
                sInfoFiltered: "(filtered from _MAX_ total entries)",
                oPaginate: {
                    sFirst: "First",
                    sPrevious: "Previous",
                    sNext: "Next",
                    sLast: "Last"
                }
            }
        });
    }
}

// Uso de la clase CustomDataTable
$(document).ready(function() {
    const myDataTable = new CustomDataTable('#example1');
});