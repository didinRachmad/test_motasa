@php
    $orderDetails = old('detail', $salesOrder->details ?? []);
    $selectedCustomer = $salesOrder->customer ?? null;
    $tanggal = isset($salesOrder) ? $salesOrder->tanggal->format('Y-m-d') : '-';
@endphp

{{-- Header --}}
<div class="row gy-2">
    <div class="col-md-4">
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal"
                class="form-control form-control-sm @error('tanggal') is-invalid @enderror"
                value="{{ old('tanggal', $tanggal) }}" required>
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4" id="customer-select-wrapper"
        data-get-customers-url="{{ route('master_customers.getCustomers') }}">
        <div class="form-group">
            <label for="selectCustomer">Customer</label>
            <select id="selectCustomer" name="customer_id"
                class="form-select form-select-sm @error('customer_id') is-invalid @enderror" required>
                @if ($selectedCustomer)
                    <option value="{{ $selectedCustomer->id }}" selected>
                        {{ $selectedCustomer->kode_customer }} – {{ $selectedCustomer->nama_toko }}
                    </option>
                @endif
            </select>
            @error('customer_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="metode_pembayaran">Metode Pembayaran</label>
            <select id="metode_pembayaran" name="metode_pembayaran"
                class="form-select form-select-sm @error('metode_pembayaran') is-invalid @enderror" required>
                @php
                    $old = old('metode_pembayaran', $salesOrder->metode_pembayaran ?? '');
                @endphp
                <option value="Tunai" {{ $old === 'Tunai' ? 'selected' : '' }}>Tunai</option>
                <option value="Transfer"{{ $old === 'Transfer' ? 'selected' : '' }}>Transfer</option>
            </select>
            @error('metode_pembayaran')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>


<hr>

<h5>Detail Produk</h5>

<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead class="table-light">
            <tr>
                <th>Produk</th>
                <th>Kemasan</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Diskon</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                @php
                    $productId = $product->id;
                    $detail = isset($salesOrder) ? $salesOrder->details->firstWhere('product_id', $productId) : null;

                    $qty = old("detail.$productId.qty", $detail->qty ?? 0);
                    $harga = $detail->harga ?? $product->harga;
                    $diskon = old("detail.$productId.diskon", $detail->diskon ?? 0);
                    $subtotal = old("detail.$productId.subtotal", $detail->subtotal ?? 0);
                @endphp
                <tr class="product-row" data-harga="{{ $harga }}">
                    <td>
                        ({{ $product->kode_produk }})
                        - {{ $product->nama_produk }}
                        <input type="hidden" name="detail[{{ $productId }}][product_id]"
                            value="{{ $productId }}">
                    </td>
                    <td>{{ $product->kemasan }}</td>
                    <td>{{ number_format($harga, 0, ',', '.') }}</td>
                    <td>
                        <input type="text" name="detail[{{ $productId }}][qty]"
                            class="form-control form-control-sm qty-input numeric" min="0"
                            value="{{ number_format($qty, 0, '', '.') }}">
                    </td>
                    <td>
                        <input type="text" class="form-control-plaintext form-control-sm diskon-input numeric"
                            name="detail[{{ $productId }}][diskon]" readonly value="0">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm subtotal-input numeric"
                            name="detail[{{ $productId }}][subtotal]" readonly
                            value="{{ number_format($subtotal, 2, ',', '.') }}">
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="bg-gd">
            <tr>
                <td colspan="5" class="text-end fw-semibold">QTY Total</td>
                <td class="text-end" id="total-qty"></td>
            </tr>
            <tr>
                <td colspan="5" class="text-end fw-semibold">Diskon Total</td>
                <td class="text-end" id="total-diskon"></td>
            </tr>
            <tr>
                <td colspan="5" class="text-end fw-semibold">Grand Total</td>
                <td class="text-end fw-bold" id="grand-total"></td>
            </tr>
        </tfoot>
    </table>
</div>
