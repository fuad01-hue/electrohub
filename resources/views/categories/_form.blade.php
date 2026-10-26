<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div>
        <x-input-label for="name" value="Nama Kategori" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                      :value="old('name', $category?->name)" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Simpan</x-primary-button>
        <a href="{{ route('categories.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
    </div>
</form>
