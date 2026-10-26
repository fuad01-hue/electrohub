<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    // INI YANG MEMBUAT TOTAL BISA TERSIMPAN:
    protected $fillable = [
        'supplier_id', 
        'user_id', 
        'purchase_number', 
        'status', 
        'purchased_at', 
        'total' 
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}