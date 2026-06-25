<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  // Daftarkan kolom yang boleh diisi melalui form
    protected $fillable = ['sku', 'name', 'unit', 'stock', 'category_id'];
}
