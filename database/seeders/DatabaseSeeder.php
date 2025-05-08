<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@zoo.com',
            'password' => Hash::make('password'),
            'admin' => true,
        ]);

        User::factory()->create([
            'name' => 'Not Admin',
            'email' => 'notadmin@zoo.com',
            'password' => Hash::make('password'),
            'admin' => false,
        ]);

        User::factory(10)->create();

        $this->call([
            EnclosureSeeder::class,
            AnimalSeeder::class,
        ]);
    }
}
