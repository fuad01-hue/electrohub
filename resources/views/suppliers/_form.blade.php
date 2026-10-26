<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div>
        <x-input-label for="name" value="Nama Pemasok" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                      :value="old('name', $supplier?->name)" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="phone" value="Telepon" />
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                      :value="old('phone', $supplier?->phone)" />
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                      :value="old('email', $supplier?->email)" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Simpan</x-primary-button>
        <a href="{{ route('suppliers.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
    </div>
</form>
