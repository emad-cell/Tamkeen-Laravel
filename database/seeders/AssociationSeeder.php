<?php

namespace Database\Seeders;

use App\Models\Association;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CleintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Association::create([
            'user_id' => 2,
            'full_name' => 'Obito Uchiha',
            'mobile_number' => '966512345678',
            'lisence'=>'123123123',
            'file_path' => 'uploads/profiles/obittto.pdf',
        ]);
    }
}
