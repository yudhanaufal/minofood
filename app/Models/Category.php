<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Agar kolom 'name' bisa diisi
    protected $fillable = ['name'];

    // Relasi ke Produk (Opsional tapi baik untuk kedepannya)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
