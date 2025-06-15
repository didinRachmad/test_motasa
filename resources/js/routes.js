window.appRoutes = {
    // getKecamatans: "/master_kecamatans/getKecamatans",
    getDesas: "/master_desas/getDesas",
    getDesasByKecamatan: (kecamatanId) =>
        `/master_desas/getDesasByKecamatan/${kecamatanId}`,
    getJenisSarpras: "/master_jenis_sarpras/getJenisSarpras",
    getRoles: "/roles/getRoles",
    getUsersByRole: (role) => `/users/getUsersByRole/${role}`,
    // tambahkan semua route lainnya di sini
};
