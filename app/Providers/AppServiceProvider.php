<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ---- Hanya Admin / Owner ----
        Gate::define('manage-master-data', fn (User $user) => $user->isAdmin()); // CRUD kategori, produk, pemasok
        Gate::define('manage-users', fn (User $user) => $user->isAdmin());       // kelola pengguna & role
        Gate::define('view-reports', fn (User $user) => $user->isAdmin());       // dashboard lengkap & laporan
        Gate::define('view-all-transactions', fn (User $user) => $user->isAdmin());
        Gate::define('cancel-transactions', fn (User $user) => $user->isAdmin());

        // ---- Admin dan Staff ----
        Gate::define('manage-sales', fn (User $user) => $user->isAdmin() || $user->isStaff());
        Gate::define('manage-purchases', fn (User $user) => $user->isAdmin() || $user->isStaff());
    }
}
