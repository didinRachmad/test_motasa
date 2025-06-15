<div class="row">
    <div class="col-md-4 mb-2">
        <label for="kode_customer">Kode Customer</label>
        <input type="text" name="kode_customer"
            class="form-control form-control-sm @error('kode_customer') is-invalid @enderror" required
            value="{{ old('kode_customer', $customer->kode_customer ?? '') }}">
        @error('kode_customer')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-2">
        <label for="nama_toko">Nama Toko</label>
        <input type="text" name="nama_toko"
            class="form-control form-control-sm @error('nama_toko') is-invalid @enderror" required
            value="{{ old('nama_toko', $customer->nama_toko ?? '') }}">
        @error('nama_toko')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-2">
        <label for="pemilik">Pemilik</label>
        <input type="text" name="pemilik" class="form-control form-control-sm @error('pemilik') is-invalid @enderror"
            value="{{ old('pemilik', $customer->pemilik ?? '') }}">
        @error('pemilik')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-2">
        <label for="alamat">Alamat</label>
        <textarea name="alamat" class="form-control form-control-sm @error('alamat') is-invalid @enderror" required>{{ old('alamat', $customer->alamat ?? '') }}</textarea>
        @error('alamat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3 mb-2">
        <label for="id_pasar">ID Pasar</label>
        <input type="number" name="id_pasar"
            class="form-control form-control-sm @error('id_pasar') is-invalid @enderror" required
            value="{{ old('id_pasar', $customer->id_pasar ?? '') }}">
        @error('id_pasar')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3 mb-2">
        <label for="nama_pasar">Nama Pasar</label>
        <input type="text" name="nama_pasar"
            class="form-control form-control-sm @error('nama_pasar') is-invalid @enderror" required
            value="{{ old('nama_pasar', $customer->nama_pasar ?? '') }}">
        @error('nama_pasar')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="tipe_outlet">Tipe Outlet</label>
        <select name="tipe_outlet" class="form-control form-control-sm @error('tipe_outlet') is-invalid @enderror"
            required>
            <option value="">-- Pilih Tipe --</option>
            @foreach (['retail', 'grosir'] as $tipe)
                <option value="{{ $tipe }}"
                    {{ old('tipe_outlet', $customer->tipe_outlet ?? '') === $tipe ? 'selected' : '' }}>
                    {{ ucfirst($tipe) }}
                </option>
            @endforeach
        </select>
        @error('tipe_outlet')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
