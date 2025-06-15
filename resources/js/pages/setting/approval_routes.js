export default {
    initIndex() {
        console.log("Halaman Approval Routes Index berhasil dimuat!");
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
                { data: "module", name: "module" },
                { data: "role", name: "roles.name" },
                { data: "sequence", name: "sequence" },
                {
                    data: "assigned_user",
                    name: "users.email",
                    render: function (data, type, row) {
                        return data
                            ? data
                            : '<span class="text-muted">-</span>';
                    },
                },
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
            order: [],
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
                // oPaginate: {
                //     sFirst: "Pertama",
                //     sLast: "Terakhir",
                //     sNext: "Selanjutnya",
                //     sPrevious: "Sebelumnya",
                // },
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
        console.log("Halaman Approval Routes Show berhasil dimuat!");
    },
    initCreate() {
        console.log("Halaman Approval Routes Create berhasil dimuat!");

        initSelect2();
        handleRoleChange();
    },
    initEdit() {
        console.log("Halaman Approval Routes Edit berhasil dimuat!");

        initSelect2();
        handleRoleChange();

        const roleSelect = $("#role_id");
        if (roleSelect.val()) {
            roleSelect.trigger("change");
        }
    },
};

const initSelect2 = () => {
    $("#module").select2({
        placeholder: "Pilih Module",
        allowClear: true,
        theme: "bootstrap-5",
        width: "100%",
    });

    $("#role_id").select2({
        placeholder: "Pilih Role",
        allowClear: true,
        theme: "bootstrap-5",
        width: "100%",
    });

    $("#assigned_user_id").select2({
        placeholder: "Pilih User",
        allowClear: true,
        theme: "bootstrap-5",
        width: "100%",
        disabled: true,
    });
};

const initUserSelect2 = (roleId) => {
    const userSelect = $("#assigned_user_id");

    userSelect.select2("destroy");
    userSelect.empty().trigger("change");

    // Inisialisasi Select2 baru
    userSelect.select2({
        placeholder: "Pilih User",
        allowClear: true,
        theme: "bootstrap-5",
        width: "100%",
        ajax: {
            url: window.appRoutes.getUsersByRole(roleId),
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                    page: params.page || 1,
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.data,
                    pagination: {
                        more: data.current_page < data.last_page,
                    },
                };
            },
        },
    });

    // Jika ada user terpilih, tambahkan opsi
    const selectedId = userSelect.data("selected-id");
    const selectedUserName = userSelect.data("selected-email");
    if (selectedId && selectedUserName) {
        const option = new Option(selectedUserName, selectedId, true, true);
        userSelect.append(option).trigger("change");
    }
};

const handleRoleChange = () => {
    $("#role_id").on("change", function () {
        const roleId = $(this).val();
        const userSelect = $("#assigned_user_id");

        userSelect.val(null).trigger("change").prop("disabled", !roleId);

        if (roleId) {
            initUserSelect2(roleId);
        }
    });
};
