@php
    $field = 'mt-1 block w-full';
    $select = 'mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm';
@endphp

<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <x-input-label for="sku" value="SKU" />
            <x-text-input id="sku" name="sku" type="text" :class="$field" :value="old('sku', $product?->sku)" required autofocus />
            <x-input-error :messages="$errors->get('sku')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="category_id" value="Kategori" />
            <select id="category_id" name="category_id" class="{{ $select }}" required>
                <option value="">Pilih kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) old('category_id', $product?->category_id) === (string) $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="name" value="Nama Produk" />
        <x-text-input id="name" name="name" type="text" :class="$field" :value="old('name', $product?->name)" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <x-input-label for="purchase_price" value="Harga Beli (Rp)" />
            <x-text-input id="purchase_price" name="purchase_price" type="number" step="0.01" min="0" :class="$field"
                          :value="old('purchase_price', $product?->purchase_price)" required />
            <x-input-error :messages="$errors->get('purchase_price')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="selling_price" value="Harga Jual (Rp)" />
            <x-text-input id="selling_price" name="selling_price" type="number" step="0.01" min="0" :class="$field"
                          :value="old('selling_price', $product?->selling_price)" required />
            <x-input-error :messages="$errors->get('selling_price')" class="mt-2" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <x-input-label for="minimum_stock" value="Stok Minimum" />
            <x-text-input id="minimum_stock" name="minimum_stock" type="number" min="0" :class="$field"
                          :value="old('minimum_stock', $product?->minimum_stock ?? 0)" required />
            <x-input-error :messages="$errors->get('minimum_stock')" class="mt-2" />
        </div>

        <div>
            @if ($product)
                <x-input-label value="Stok Saat Ini" />
                <p class="mt-2 text-sm text-gray-900">{{ $product->stock }}</p>
                <p class="mt-1 text-xs text-gray-500">Stok hanya berubah lewat transaksi pembelian dan penjualan.</p>
            @else
                <x-input-label for="stock" value="Stok Awal" />
                <x-text-input id="stock" name="stock" type="number" min="0" :class="$field" :value="old('stock', 0)" required />
                <p class="mt-1 text-xs text-gray-500">Saldo awal. Setelah dibuat, stok hanya berubah lewat transaksi.</p>
                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
            @endif
        </div>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Simpan</x-primary-button>
        <a href="{{ route('products.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
    </div>
</form>
