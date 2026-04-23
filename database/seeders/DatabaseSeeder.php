<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Alejandro',
            'last_name' => 'Rivas',
            'email' => 'alejandro@test.com',
        ]);

        User::factory(10)->create();
    }
}
