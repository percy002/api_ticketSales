<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
Use App\Models\TiposTicket;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        TiposTicket::create([
            'nombre' => 'General',
            'precio' => 10.00,
            'turno' => 'mañana',
        ]);
        TiposTicket::create([
            'nombre' => 'estelar',
            'precio' => 30.00,
            'turno' => 'tarde',
        ]);
    }
}
