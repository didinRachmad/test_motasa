<div class="row">
    <!-- Kode Produk -->
    <div class="col-12 mb-2">
        <label for="kode_produk">Kode Produk <span class="text-danger">*</span></label>
        <input type="text" name="kode_produk"
            class="form-control form-control-sm @error('kode_produk') is-invalid @enderror"
            value="{{ old('kode_produk', $product->kode_produk ?? '') }}">
        @error('kode_produk')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Nama Produk -->
    <div class="col-12 mb-2">
        <label for="nama_produk">Nama Produk <span class="text-danger">*</span></label>
        <input type="text" name="nama_produk"
            class="form-control form-control-sm @error('nama_produk') is-invalid @enderror"
            value="{{ old('nama_produk', $product->nama_produk ?? '') }}">
        @error('nama_produk')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Harga -->
    <div class="col-12 mb-2">
        <label for="harga">Harga <span class="text-danger">*</span></label>
        <input type="number" name="harga" min="0"
            class="form-control form-control-sm @error('harga') is-invalid @enderror"
            value="{{ old('harga', $product->harga ?? '') }}">
        @error('harga')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Kemasan -->
    <div class="col-12 mb-2">
        <label for="kemasan">Kemasan <span class="text-danger">*</span></label>
        <select name="kemasan" class="form-control form-control-sm @error('kemasan') is-invalid @enderror">
            <option value="">-- Pilih Kemasan --</option>
            @foreach (['Pack', 'Rtg', 'Pcs', 'Krt'] as $opt)
                <option value="{{ $opt }}"
                    {{ old('kemasan', $product->kemasan ?? '') === $opt ? 'selected' : '' }}>
                    {{ $opt }}
                </option>
            @endforeach
        </select>
        @error('kemasan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
