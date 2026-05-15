<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RegionsSeeder extends Seeder
{
    public function run()
    {
        if ($this->db->table('regions')->countAllResults() > 0) {
            return;
        }
        $now = date('Y-m-d H:i:s');
        $regions = [
            ['name' => 'National Capital Region',                   'slug' => 'ncr',         'code' => 'NCR',  'lat' => 14.5995,  'lng' => 120.9842, 'pop' => 13484462],
            ['name' => 'Cordillera Administrative Region',          'slug' => 'car',         'code' => 'CAR',  'lat' => 16.4023,  'lng' => 120.5960, 'pop' => 1797660],
            ['name' => 'Region I — Ilocos Region',                  'slug' => 'region-1',    'code' => 'R1',   'lat' => 17.5707,  'lng' => 120.3858, 'pop' => 5301139],
            ['name' => 'Region II — Cagayan Valley',                'slug' => 'region-2',    'code' => 'R2',   'lat' => 17.6132,  'lng' => 121.7270, 'pop' => 3685744],
            ['name' => 'Region III — Central Luzon',                'slug' => 'region-3',    'code' => 'R3',   'lat' => 15.4828,  'lng' => 120.7120, 'pop' => 12422172],
            ['name' => 'Region IV-A — CALABARZON',                  'slug' => 'region-4a',   'code' => 'R4A',  'lat' => 14.1008,  'lng' => 121.0794, 'pop' => 16195042],
            ['name' => 'Region IV-B — MIMAROPA',                    'slug' => 'region-4b',   'code' => 'R4B',  'lat' => 12.8797,  'lng' => 121.7740, 'pop' => 3228558],
            ['name' => 'Region V — Bicol Region',                   'slug' => 'region-5',    'code' => 'R5',   'lat' => 13.4210,  'lng' => 123.4136, 'pop' => 6082165],
            ['name' => 'Region VI — Western Visayas',               'slug' => 'region-6',    'code' => 'R6',   'lat' => 10.7202,  'lng' => 122.5621, 'pop' => 7954723],
            ['name' => 'Region VII — Central Visayas',              'slug' => 'region-7',    'code' => 'R7',   'lat' => 10.3157,  'lng' => 123.8854, 'pop' => 8081988],
            ['name' => 'Region VIII — Eastern Visayas',             'slug' => 'region-8',    'code' => 'R8',   'lat' => 11.2421,  'lng' => 125.0011, 'pop' => 4547150],
            ['name' => 'Region IX — Zamboanga Peninsula',           'slug' => 'region-9',    'code' => 'R9',   'lat' => 8.1545,   'lng' => 123.2587, 'pop' => 3875576],
            ['name' => 'Region X — Northern Mindanao',              'slug' => 'region-10',   'code' => 'R10',  'lat' => 8.4542,   'lng' => 124.6319, 'pop' => 5022768],
            ['name' => 'Region XI — Davao Region',                  'slug' => 'region-11',   'code' => 'R11',  'lat' => 7.0731,   'lng' => 125.6128, 'pop' => 5243536],
            ['name' => 'Region XII — SOCCSKSARGEN',                 'slug' => 'region-12',   'code' => 'R12',  'lat' => 6.2727,   'lng' => 124.6856, 'pop' => 4901486],
            ['name' => 'Region XIII — Caraga',                      'slug' => 'region-13',   'code' => 'R13',  'lat' => 8.9456,   'lng' => 125.5404, 'pop' => 2804788],
            ['name' => 'Bangsamoro Autonomous Region (BARMM)',      'slug' => 'barmm',       'code' => 'BARMM','lat' => 7.2056,   'lng' => 124.2422, 'pop' => 4404288],
        ];

        $rows = [];
        foreach ($regions as $r) {
            $rows[] = [
                'name'       => $r['name'],
                'slug'       => $r['slug'],
                'code'       => $r['code'],
                'type'       => 'region',
                'parent_id'  => null,
                'latitude'   => $r['lat'],
                'longitude'  => $r['lng'],
                'population' => $r['pop'],
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        $this->db->table('regions')->insertBatch($rows);
    }
}
