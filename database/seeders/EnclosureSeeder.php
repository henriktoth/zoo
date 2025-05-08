<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Enclosure;
use App\Models\User;
use App\Models\Animal;

class EnclosureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $enclosures = Enclosure::factory(10)->create();
        $users = User::all();

        foreach ($enclosures as $enclosure) {
            $randomUsers = $users->random(fake()->numberBetween(1, 3))->pluck('id');
            $enclosure->users()->attach($randomUsers);
        }
    }
}
