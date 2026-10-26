@php
    $select = 'mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm';
    $isSelf = $user && $user->is(auth()->user());
@endphp

<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div>
        <x-input-label for="name" value="Nama" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                      :value="old('name', $user?->name)" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                      :value="old('email', $user?->email)" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="role" value="Role" />
        @if ($isSelf)
            <select id="role" class="{{ $select }} bg-gray-100" disabled>
                <option>{{ strtoupper($user->role) }}</option>
            </select>
            <input type="hidden" name="role" value="{{ $user->role }}">
            <p class="mt-1 text-xs text-gray-500">Anda tidak dapat mengubah role akun Anda sendiri.</p>
        @else
            <select id="role" name="role" class="{{ $select }}" required>
                @foreach ([\App\Models\User::ROLE_ADMIN => 'Admin / Owner', \App\Models\User::ROLE_STAFF => 'Staff'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('role', $user?->role ?? \App\Models\User::ROLE_STAFF) === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        @endif
        <x-input-error :messages="$errors->get('role')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="password" :value="$user ? 'Password Baru (kosongkan jika tidak diubah)' : 'Password'" />
        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                      autocomplete="new-password" :required="! $user" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="password_confirmation" value="Konfirmasi Password" />
        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full"
                      autocomplete="new-password" :required="! $user" />
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Simpan</x-primary-button>
        <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
    </div>
</form>
