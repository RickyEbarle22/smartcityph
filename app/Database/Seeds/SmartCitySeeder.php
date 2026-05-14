<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SmartCitySeeder extends Seeder
{
    public function run()
    {
        helper('text');
        helper('url');
        $this->call('RegionsSeeder');
        $this->call('AgenciesSeeder');
        $this->call('ServicesSeeder');
        $this->call('NewsSeeder');
        $this->call('SampleDataSeeder');
        $this->call('FaqsSeeder');
        $this->call('FoisSeeder');
    }
}
