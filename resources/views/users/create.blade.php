<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Pengguna</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                @include('users._form', ['user' => null, 'action' => route('users.store'), 'method' => 'POST'])
            </div>
        </div>
    </div>
</x-app-layout>
