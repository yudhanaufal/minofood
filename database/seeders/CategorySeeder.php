<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; 

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar kategori yang Anda minta
        $categories = [
            'Cup kopi',
            'Cup milk base',
            'Paper cup',
            'Package S',
            'Package M',
            'Package L',
            'Kopi',
            'Fresh Milk',
            'Susu UHT'

        ];
         foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat]);
         }   
    }
}
