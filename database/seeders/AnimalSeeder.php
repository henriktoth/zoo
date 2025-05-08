<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Enclosure;
use App\Models\Animal;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enclosures = Enclosure::all();

        foreach ($enclosures as $enclosure) {

            $animalCount = fake()->numberBetween(1, $enclosure->limit);
            $isPredatorEnclosure = fake()->boolean();

            Animal::factory($animalCount)->create([
                'enclosure_id' => $enclosure->id,
                'is_predator' => $isPredatorEnclosure,
            ]);
        }
    }
}
