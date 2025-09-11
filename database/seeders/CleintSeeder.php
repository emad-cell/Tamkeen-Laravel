<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CleintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::create([
            'user_id' => 3,
            'full_name' => 'Obito Uchiha',
            'mobile_number' => '966512345678',
            'file_path' => 'uploads/profiles/obito.pdf',
        ]);
    }
}
