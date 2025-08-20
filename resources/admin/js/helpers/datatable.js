export function initializeDataTable(config) {
    $(`#${config.tableId}`).DataTable({
        retrieve: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: config.ajaxUrl,
            type: "GET"
        },
        columns: config.columns,
        buttons: config.buttons,
        dom: '<"datatable-header justify-content-start"f<"ms-sm-auto"l><"ms-sm-3"B>><"datatable-scroll"t><"datatable-footer"ip>',
        language: config.language
    });
}
