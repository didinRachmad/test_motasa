# Panduan Instalasi Aplikasi Laravel — Test Motasa

Dokumen ini berisi langkah-langkah instalasi dan informasi akun awal yang diperlukan untuk menjalankan aplikasi **Test Motasa** berbasis Laravel 10.

---

## 🔧 Persyaratan Sistem

Pastikan sistem Anda telah memenuhi persyaratan berikut:

- PHP versi 8.1 atau lebih baru  
- Composer 2.x  
- Node.js 18.x dan NPM 9.x  
- MySQL 5.7 atau MariaDB 10.3  
- Laravel 10.x

---

## ⚙️ Langkah Instalasi

Lakukan instalasi dengan mengikuti urutan perintah berikut di terminal:

1. **Clone repository** (jika belum):
   ```bash
   git clone [https://github.com/username/nama-repo.git](https://github.com/didinRachmad/test_motasa.git)
   ```

2. **Install dependency PHP**:
   ```bash
   composer install
   ```

3. **Install dependency JavaScript**:
   ```bash
   npm install
   ```

4. **Salin file .env dari template dan sesuaikan konfigurasi database**:
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

6. **Migrasi dan seed database**:
   ```bash
   php artisan migrate --seed
   ```

7. **Jalankan server lokal Laravel**:
   ```bash
   php artisan serve
   ```

8. **Build asset frontend untuk produksi**:
   ```bash
   npm run build
   ```

9. **Bersihkan cache konfigurasi, route, dan view**:
   ```bash
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

---

## 👤 Data User, Role, dan Permission

### Akun Default (hasil dari seeder)

- **Email**: admin@gmail.com | **Password**: 12345678 | **Role**: Super Admin  
- **Email**: admin@depo.com | **Password**: 12345678 | **Role**: Admin Depo  
- **Email**: spv@depo.com   | **Password**: 12345678 | **Role**: SPV Depo  

---

## 🔐 Struktur Role & Akses

### Super Admin
- Akses penuh ke seluruh sistem  
- Termasuk manajemen user, role, dan data master

### Admin Depo
- Kelola data operasional depo (master & transaksi)  
- Tidak memiliki akses ke manajemen user

### SPV Depo
- Melihat data dan memberikan approval  
- Tidak dapat mengubah data master
