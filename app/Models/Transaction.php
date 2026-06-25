<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['product_id', 'user_id', 'type', 'quantity', 'date'];

    // Relasi ke Produk (Satu transaksi punya satu produk)
    public function product() {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke User (Siapa yang input)
    public function user() {
        return $this->belongsTo(User::class);
    }
}