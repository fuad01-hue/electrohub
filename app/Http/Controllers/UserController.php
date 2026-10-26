<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    private function roles(): array
    {
        return [User::ROLE_ADMIN, User::ROLE_STAFF];
    }

    public function index(Request $request): View
    {
        $users = User::query()
            ->when($request->q, function ($query, $term) {
                $query->where(fn ($w) => $w->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%"));
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', Rule::in($this->roles())],
        ]);

        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // di-hash oleh cast 'hashed'
        ]);
        $user->role = $data['role']; // role tidak mass-assignable, di-set eksplisit
        $user->save();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => ['required', Rule::in($this->roles())],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        // Admin tidak boleh menurunkan role dirinya sendiri (mencegah sistem tanpa admin).
        if (! $user->is($request->user())) {
            $user->role = $data['role'];
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }
}
