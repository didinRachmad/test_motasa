export default {
    initIndex() {
        console.log("Halaman Roles Index berhasil dimuat!");
        let table;
        table = $("#datatables");
        let url = table.data("url");
        table = table.DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                },
                { data: "id", name: "id", visible: false },
                { data: "title", name: "title" },
                { data: "route", name: "route" },
                { data: "icon", name: "icon" },
                { data: "order", name: "order" },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center no-export",
                    render: function (data, type, row) {
                        let buttons = "";
                        if (row.can_edit) {
                            buttons += `<a href="${row.edit_url}" class="btn btn-sm btn-warning rounded-4" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="bi bi-pencil-square"></i></a> `;
                        }
                        if (row.can_delete) {
                            buttons += `
                            <form action="${
                                row.delete_url
                            }" method="POST" class="d-inline form-delete">
                                <input type="hidden" name="_token" value="${$(
                                    'meta[name="csrf-token"]'
                                ).attr("content")}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="button" class="btn btn-sm btn-danger rounded-4 btn-delete" data-bs-toggle="tooltip" data-bs-title="Hapus"><i class="bi bi-trash-fill"></i></button>
                            </form>`;
                        }
                        return `<div class="d-flex justify-content-center gap-1">${buttons}</div>`;
                    },
                },
            ],
            dom:
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-6 mb-3 mb-md-0 d-flex justify-content-center align-items-center'><'col-sm-12 col-md-3 text-right'f>>" +
                "<'row py-2'<'col-sm-12 table-responsive'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            paging: true,
            responsive: true,
            pageLength: 20,
            lengthMenu: [
                [20, 50, -1],
                [20, 50, "Semua"],
            ],
            order: [[1, 'desc']],
            columnDefs: [
                {
                    targets: 0, // Menargetkan kolom pertama
                    className: "text-center", // Menambahkan kelas text-center untuk meratakan teks ke tengah
                },
            ],
            info: true,
            language: {
                sEmptyTable: "Tidak ada data yang tersedia di tabel",
                sInfo: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                sInfoEmpty: "Menampilkan 0 hingga 0 dari 0 entri",
                sInfoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                sInfoPostFix: "",
                sInfoThousands: ".",
                sLengthMenu: "Tampilkan _MENU_ entri",
                sLoadingRecords: "Memuat...",
                sProcessing: "Sedang memproses...",
                sSearch: "Cari:",
                sZeroRecords: "Tidak ditemukan data yang cocok",
                oAria: {
                    sSortAscending:
                        ": aktifkan untuk mengurutkan kolom secara menaik",
                    sSortDescending:
                        ": aktifkan untuk mengurutkan kolom secara menurun",
                },
            },
            drawCallback: function () {
                $('[data-bs-toggle="tooltip"]').each(function () {
                    new bootstrap.Tooltip(this);
                });
            },
        });
    },
    initShow() {
        console.log("Halaman Menu Show berhasil dimuat!");
    },
    initCreate() {
        console.log("Halaman Menu Create berhasil dimuat!");
    },
    initEdit() {
        console.log("Halaman Menu Edit berhasil dimuat!");
    },
};
