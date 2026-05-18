<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@booking.com',
            'password' => bcrypt('admin123'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Guru Test',
            'email'    => 'guru@booking.com',
            'password' => bcrypt('guru123'),
            'role'     => 'guru',
        ]);

        User::create([
            'name'     => 'Umum Test',
            'email'    => 'user@booking.com',
            'password' => bcrypt('umum123'),
            'role'     => 'umum',
        ]);
    }
}
