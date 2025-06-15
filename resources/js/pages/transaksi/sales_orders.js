import AutoNumeric from "autonumeric";
import { formatNumber, formatRupiah } from "@/utils/format";

class SalesOrdersPage {
    constructor() {
        // Elemen & URL
        this.datatableEl = $("#datatables");
        this.customerSelectEl = $("#selectCustomer");
        this.customerUrl = $("#customer-select-wrapper").data(
            "get-customers-url"
        );
    }

    // Halaman index
    initIndex() {
        console.log("Halaman Transaksi SO Index berhasil dimuat!");
        this.initDataTable();
    }

    // Halaman show
    initShow() {
        console.log("Halaman Transaksi SO Show berhasil dimuat!");
        // logic khusus jika perlu
    }

    // Halaman create
    initCreate() {
        console.log("Halaman Transaksi SO Create berhasil dimuat!");
        this.initForm();
    }

    // Halaman edit
    initEdit() {
        console.log("Halaman Transaksi SO Edit berhasil dimuat!");
        this.initForm();
    }

    // ————— DataTable setup —————
    initDataTable() {
        this.datatableEl.DataTable({
            processing: true,
            serverSide: true,
            ajax: this.datatableEl.data("url"),
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                },
                { data: "no_so", name: "no_so", className: "text-center" },
                { data: "tanggal", name: "tanggal" },
                { data: "customer", name: "customer" },
                {
                    data: "metode_pembayaran",
                    name: "metode_pembayaran",
                    className: "text-center",
                },
                { data: "total_qty", name: "total_qty", className: "text-end" },
                {
                    data: "total_diskon",
                    name: "total_diskon",
                    className: "text-end",
                    render: $.fn.dataTable.render.number(".", ",", 0, "Rp "),
                },
                {
                    data: "grand_total",
                    name: "grand_total",
                    className: "text-end fw-bold",
                    render: $.fn.dataTable.render.number(".", ",", 0, "Rp "),
                },
                { data: "approval_level", name: "approval_level" },
                { data: "status", name: "status" },
                { data: "keterangan", name: "keterangan" },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center no-export",
                    render: function (data, type, row) {
                        let buttons = "";

                        // Tombol Detail
                        if (row.can_show) {
                            buttons += `
                                <a href="${row.show_url}" class="btn btn-sm rounded-4 btn-info" data-bs-toggle="tooltip" title="Detail">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            `;
                        }

                        // Tombol Approve / Action
                        const canApprove =
                            row.approval_level == row.approval_sequence - 1 &&
                            row.status !== "Rejected";

                        if (canApprove) {
                            if (row.approval_level == 0) {
                                buttons += `
                                    <form action="${
                                        row.approve_url
                                    }" method="POST" class="d-inline form-approval">
                                        <input type="hidden" name="_token" value="${$(
                                            'meta[name="csrf-token"]'
                                        ).attr("content")}">
                                        <button type="submit" class="btn btn-sm rounded-4 btn-success btn-approve" data-bs-toggle="tooltip" title="Ajukan">
                                            <i class="bi bi-check2-square"></i>
                                        </button>
                                    </form>
                                `;
                            } else {
                                buttons += `
                                    <div class="dropdown dropstart d-inline">
                                        <button class="btn btn-sm rounded-4 btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" title="Action">
                                            <i class="bi bi-gear-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <form action="${
                                                    row.revisi_url
                                                }" method="POST" class="form-revisi">
                                                    <input type="hidden" name="_token" value="${$(
                                                        'meta[name="csrf-token"]'
                                                    ).attr("content")}">
                                                    <button type="submit" class="dropdown-item text-warning btn-revisi">
                                                        <i class="bi bi-arrow-clockwise"></i> Revisi
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="${
                                                    row.approve_url
                                                }" method="POST" class="form-approval">
                                                    <input type="hidden" name="_token" value="${$(
                                                        'meta[name="csrf-token"]'
                                                    ).attr("content")}">
                                                    <button type="submit" class="dropdown-item text-success btn-approve">
                                                        <i class="bi bi-check2-square"></i> Approve
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="${
                                                    row.reject_url
                                                }" method="POST" class="form-reject">
                                                    <input type="hidden" name="_token" value="${$(
                                                        'meta[name="csrf-token"]'
                                                    ).attr("content")}">
                                                    <button type="button" class="dropdown-item text-danger btn-reject">
                                                        <i class="bi bi-x-square-fill"></i> Reject
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                `;
                            }
                        }

                        const canModify = row.approval_level == 0;

                        if (canModify) {
                            if (row.can_edit) {
                                buttons += `
                                    <a href="${row.edit_url}" class="btn btn-sm rounded-4 btn-warning" data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                `;
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
                                        <button type="button" class="btn btn-sm rounded-4 btn-danger btn-delete" data-bs-toggle="tooltip" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                `;
                            }
                        }

                        return `<div class="d-flex justify-content-center gap-1 flex-wrap">${buttons}</div>`;
                    },
                },
            ],
            dom:
                "<'row'<'col-md-3'l><'col-md-6 text-center'><'col-md-3'f>>" +
                "<'row py-2'<'col-sm-12'tr>>" +
                "<'row'<'col-md-5'i><'col-md-7'p>>",
            paging: true,
            responsive: true,
            pageLength: 20,
            lengthMenu: [
                [20, 50, -1],
                [20, 50, "Semua"],
            ],
            order: [],
            info: true,
            language: {
                sEmptyTable: "Tidak ada data yang tersedia di tabel",
                sInfo: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                sInfoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                sLengthMenu: "Tampilkan _MENU_ entri",
                sLoadingRecords: "Memuat...",
                sProcessing: "Sedang memproses...",
                sSearch: "Cari:",
                sZeroRecords: "Tidak ditemukan data yang cocok",
                oAria: {
                    sSortAscending: ": aktifkan untuk mengurutkan kolom menaik",
                    sSortDescending:
                        ": aktifkan untuk mengurutkan kolom menurun",
                },
            },
            drawCallback: () =>
                $('[data-bs-toggle="tooltip"]').each(function () {
                    new bootstrap.Tooltip(this);
                }),
        });
    }

    // ————— Form SO —————
    initForm() {
        this.setupCustomerSelect();
        this.initAutoNumeric();
        this.attachQtyListeners();
        this.calculateAll();
    }

    setupCustomerSelect() {
        this.customerSelectEl.select2({
            theme: "bootstrap-5",
            placeholder: "Pilih customer…",
            allowClear: true,
            ajax: {
                url: this.customerUrl,
                dataType: "json",
                delay: 250,
                data: (params) => ({
                    q: params.term,
                    page: params.page || 1,
                }),
                processResults: (data, params) => ({
                    results: data.results.map((item) => ({
                        id: item.id,
                        kode_customer: item.kode_customer,
                        nama_toko: item.nama_toko,
                        id_pasar: item.id_pasar,
                        nama_pasar: item.nama_pasar,
                        text: `${item.kode_customer} – ${item.nama_toko}`,
                    })),
                    pagination: {
                        more: data.pagination?.more || false,
                    },
                }),
                cache: true,
            },
            templateResult: ({
                loading,
                kode_customer,
                nama_toko,
                id_pasar,
                nama_pasar,
            }) =>
                loading
                    ? "Mencari…"
                    : $(`<div>
                        <strong>${kode_customer}</strong> – ${nama_toko}<br>
                        <small class="text-muted">Pasar: ${id_pasar} – ${nama_pasar}</small>
                    </div>`),
            templateSelection: (d) =>
                d.kode_customer
                    ? `${d.kode_customer} – ${d.nama_toko}`
                    : d.text || "Pilih customer…",
        });
    }

    initAutoNumeric() {
        document
            .querySelectorAll(".diskon-input, .subtotal-input")
            .forEach((el) => {
                new AutoNumeric(el, {
                    digitGroupSeparator: ".",
                    decimalCharacter: ",",
                    decimalPlaces: 0,
                });
            });
    }

    calculateAll() {
        let totalQty = 0,
            totalDiskon = 0,
            totalGrand = 0;
        document.querySelectorAll(".product-row").forEach((row) => {
            const harga = parseFloat(row.dataset.harga);
            const qty = parseInt(row.querySelector(".qty-input").value) || 0;
            const total = harga * qty;
            const diskon = qty >= 20 ? total * 0.05 : 0;
            const subtotal = total - diskon;

            totalQty += qty;
            totalDiskon += diskon;
            totalGrand += subtotal;

            AutoNumeric.getAutoNumericElement(
                row.querySelector(".diskon-input")
            ).set(diskon);
            AutoNumeric.getAutoNumericElement(
                row.querySelector(".subtotal-input")
            ).set(subtotal);
        });

        $("#total-qty").text(totalQty);
        $("#total-diskon").text(`Rp ${formatRupiah(totalDiskon)}`);
        $("#grand-total").text(`Rp ${formatRupiah(totalGrand)}`);
    }

    attachQtyListeners() {
        document.querySelectorAll(".qty-input").forEach((input) => {
            input.addEventListener("input", () => this.calculateAll());
        });
    }
}

export default new SalesOrdersPage();
