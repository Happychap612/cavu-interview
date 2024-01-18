<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\CarPark;
use App\Models\CarPark\Space;
use App\Models\Customer;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $carPark = CarPark::create([
            'name' => 'Manchester Airport',
        ]);

        $spaces = [];
        for ($i=1; $i <= 10; $i++) { 
            $spaces[] = [
                'name' => 'A' . $i,
            ];
        }
        $carPark->spaces()->createMany($spaces);

        $customers = Customer::factory()->count(10)->create();
    }
}
