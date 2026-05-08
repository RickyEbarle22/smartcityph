<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SmartCitySeeder extends Seeder
{
    public function run()
    {
        helper('text');
        $this->call('RegionsSeeder');
        $this->call('ServicesSeeder');
        $this->call('NewsSeeder');
        $this->call('SampleDataSeeder');
    }
}
