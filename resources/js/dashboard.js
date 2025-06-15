// ==================== IMPORTS ====================

// Plugins & CSS
import select2 from "select2";
import "datatables.net-bs5";
import "datatables.net-buttons-bs5";
import "datatables.net-buttons/js/buttons.html5.js";
import "datatables.net-buttons/js/buttons.print.js";
import "datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css";
import Pace from "pace-js/pace.min";
import PerfectScrollbar from "perfect-scrollbar";
import "simplebar";
import AutoNumeric from "autonumeric";
import "./main";

// PDF & Excel support untuk Buttons
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
import JSZip from "jszip";
import {
    showAlert,
    showConfirmDialog,
    showInputDialog,
    showToast,
} from "./modules/sweetalert.js";

// ==================== GLOBAL SETUP ====================

select2(); // init Select2 (jQuery-based)
Pace.start(); // init loading bar

pdfMake.vfs = pdfFonts.vfs;
window.JSZip = JSZip;
window.pdfMake = pdfMake;

window.showAlert = showAlert;
window.showConfirmDialog = showConfirmDialog;
window.showInputDialog = showInputDialog;
window.showToast = showToast;

// URL API
window.API_URLS = {
    items: import.meta.env.VITE_API_ITEMS_SERVICE,
};

// Dynamic import modules/pages
const pageModules = import.meta.glob("./pages/**/*.js");

// ==================== UTILITIES ====================

const capitalize = (s) => s?.charAt(0).toUpperCase() + s.slice(1);

// Inisialisasi Bootstrap tooltip
const initTooltips = () =>
    document
        .querySelectorAll('[data-bs-toggle="tooltip"]')
        .forEach((el) => new bootstrap.Tooltip(el));

// Handle konfirmasi & input dialog
const handleConfirmationClick = (e) => {
    const btn = e.target.closest("button");
    if (!btn) return;
    const form = btn.closest("form");

    const config = [
        [
            "btn-submit",
            "Konfirmasi Penyimpanan",
            "Periksa kembali inputan anda sebelum menyimpan!",
            () => form.submit(),
            "submit",
        ],
        [
            "btn-delete",
            "Konfirmasi Penghapusan",
            "Data yang dihapus tidak dapat dikembalikan!",
            () => form.submit(),
            "delete",
        ],
        [
            "btn-approve",
            "Apakah Anda yakin?",
            "Harap periksa kembali sebelum melakukan approve data!",
            () => form.submit(),
            "submit",
        ],
        [
            "btn-reset-password",
            "Apakah Anda yakin?",
            "Password akan direset ke data awal!",
            () => form.submit(),
            "default",
        ],
    ];

    for (const [cls, title, text, cb, icon] of config) {
        if (btn.classList.contains(cls)) {
            e.preventDefault();
            return showConfirmDialog(title, text, cb, icon);
        }
    }

    if (
        btn.classList.contains("btn-revisi") ||
        btn.classList.contains("btn-reject")
    ) {
        e.preventDefault();
        const isRevisi = btn.classList.contains("btn-revisi");
        const txt = isRevisi
            ? "Data item akan dikembalikan untuk proses revisi, silakan tambahkan keterangan!"
            : "Data item akan direject! Silakan tambahkan alasan reject.";
        showInputDialog("Apakah Anda yakin?", txt, (keterangan) => {
            form.insertAdjacentHTML(
                "beforeend",
                `<input type="hidden" name="keterangan" value="${keterangan}">`
            );
            form.submit();
        });
    }
};

// Load module halaman sesuai data-page & data-action
const initPageModule = async () => {
    const page = document.body.dataset.page;
    const action = document.body.dataset.action;
    if (!page) return;

    const path = `./pages/${page}.js`;
    if (!pageModules[path]) {
        return console.error(`Modul untuk halaman "${page}" tidak ditemukan`);
    }

    try {
        const mod = await pageModules[path]();
        const fn = `init${capitalize(action)}`;
        if (typeof mod.default?.[fn] === "function") {
            mod.default[fn]();
        } else {
            console.error(`Fungsi "${fn}" tidak ditemukan di ${page}`);
        }
    } catch (err) {
        console.error(`Gagal memuat modul halaman "${page}"`, err);
    }
};

// ==================== SEARCH FUNCTIONALITY ====================

const ps = new PerfectScrollbar(".search-content", {
    wheelSpeed: 1,
    wheelPropagation: false,
    minScrollbarLength: 20,
});

const formatTitle = (key) =>
    key
        .split("_")
        .map((w) => capitalize(w))
        .join(" ");

const updateSearchResults = (data) => {
    const resultsEl = document.getElementById("search-results");
    const seeAll = document.getElementById("see-all-results");
    let html = "",
        total = 0;

    if (data.error) {
        html = `<div class="alert alert-danger m-3">${data.error}</div>`;
    } else {
        for (const [key, items] of Object.entries(data)) {
            if (!items?.length) continue;
            total += items.length;
            html += `<p class="search-title">${formatTitle(
                key
            )}</p><div class="search-list d-flex flex-column gap-2">`;
            items.forEach(({ url = "#", icon = "search", display }) => {
                html += `
          <a href="${url}" class="search-list-item d-flex align-items-center gap-3">
            <div class="list-icon"><i class="material-icons-outlined fs-5">${icon}</i></div>
            <div class="text-light">${display}</div>
          </a>`;
            });
            html += `</div><hr>`;
            ps.update();
        }
        if (!html) {
            html =
                '<p class="text-muted m-3">Tidak ditemukan hasil pencarian</p>';
        }
    }

    // Update tombol "See All"
    const query = document.querySelector(
        "#search-input, #mobile-search-input"
    )?.value;
    if (query && total) {
        seeAll.href = `/search/all?q=${encodeURIComponent(query)}`;
        seeAll.classList.remove("d-none");
        seeAll.innerHTML = `<i class="material-icons-outlined me-2">search</i>
                        Lihat Semua Hasil (${total}+)`;
    } else {
        seeAll.classList.add("d-none");
    }

    resultsEl.innerHTML = html;
};

const performSearch = async (q) => {
    const popup = document.querySelector(".search-popup");
    const resultsEl = document.getElementById("search-results");
    if (q.length < 2) {
        resultsEl.innerHTML = "";
        return popup.classList.add("d-none");
    }
    popup.classList.remove("d-none");
    resultsEl.innerHTML = `<div class="text-center p-3">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <p class="mt-2">Mencari...</p>
  </div>`;

    try {
        const resp = await fetch(`/search?q=${encodeURIComponent(q)}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        });
        if (!resp.ok) throw new Error(resp.status);
        const data = await resp.json();
        updateSearchResults(data);
    } catch (err) {
        console.error("Search error:", err);
        resultsEl.innerHTML = `<div class="alert alert-danger m-3">
      Gagal memuat hasil pencarian. Silakan coba lagi.
    </div>`;
    }
};

const initSearch = () => {
    const inputs = document.querySelectorAll(
        "#search-input, #mobile-search-input"
    );
    const popup = document.querySelector(".search-popup");
    let timeout;

    const debounce = (fn, delay) => {
        clearTimeout(timeout);
        timeout = setTimeout(fn, delay);
    };

    inputs.forEach((inp) => {
        inp.addEventListener("input", (e) =>
            debounce(() => performSearch(e.target.value.trim()), 300)
        );
        inp.addEventListener("focus", () => {
            if (inp.value.length > 1) popup.classList.remove("d-none");
        });
    });

    document
        .querySelectorAll(".search-close, .mobile-search-close")
        .forEach((btn) =>
            btn.addEventListener("click", () => {
                popup.classList.add("d-none");
                inputs.forEach((i) => (i.value = ""));
            })
        );

    document.addEventListener("click", (e) => {
        if (!e.target.closest(".search-bar")) popup.classList.add("d-none");
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") popup.classList.add("d-none");
    });
};

// ==================== INIT ALL ====================

document.addEventListener("DOMContentLoaded", async () => {
    await initPageModule();
});
document.addEventListener("DOMContentLoaded", function () {
    initTooltips();
    document.addEventListener("click", handleConfirmationClick);
    initSearch();
    document.querySelectorAll("input.numeric").forEach((el) => {
        new AutoNumeric(el, {
            digitGroupSeparator: ".",
            decimalCharacter: ",",
            decimalPlaces: 0,
            unformatOnSubmit: true,
            modifyValueOnWheel: false,
            selectNumberOnlyOnFocus: true,
        });
    });
});
