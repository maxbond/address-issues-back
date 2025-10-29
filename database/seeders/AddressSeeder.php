<?php

namespace Database\Seeders;

use App\Models\Street;
use App\Models\House;
use App\Models\Location;
use App\Models\Address;

use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    public function run(): void
    {

        Location::factory(1)->has(
            Street::factory(10)->has(Address::factory(rand(1, 3)))
        )->create();
    }
}
