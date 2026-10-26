<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // INI KUNCI AGAR ALAMAT, EMAIL, & TELEPON BISA TERSIMPAN:
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}