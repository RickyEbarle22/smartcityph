<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $articles = [
            [
                'title' => 'SmartCity PH launches as the official one-stop digital government services hub',
                'category' => 'Announcements',
                'excerpt' => 'A unified portal connecting Filipino citizens to government services across all 17 regions of the Philippines is now live.',
                'is_featured' => 1,
            ],
            [
                'title' => 'PhilHealth widens coverage for outpatient mental health services in 2026',
                'category' => 'Health',
                'excerpt' => 'PhilHealth members can now access broader mental health benefits including outpatient consultations and prescribed medication.',
                'is_featured' => 0,
            ],
            [
                'title' => 'DTI rolls out streamlined Business Name Registration online for faster startup setup',
                'category' => 'Business',
                'excerpt' => 'Entrepreneurs can now register their business names through the DTI BNRS portal in just minutes.',
                'is_featured' => 0,
            ],
            [
                'title' => 'LTO opens new e-Driver’s License renewal pilot in Metro Manila branches',
                'category' => 'Transportation',
                'excerpt' => 'A faster electronic license renewal pilot is now available in select LTO offices across the National Capital Region.',
                'is_featured' => 0,
            ],
            [
                'title' => 'DSWD expands 4Ps cash grants in time for school year 2026–2027',
                'category' => 'Social Welfare',
                'excerpt' => 'Education and health grants under the Pantawid Pamilyang Pilipino Program will see top-ups for elementary and senior high learners.',
                'is_featured' => 0,
            ],
            [
                'title' => 'TESDA offers 60+ free skills training programs nationwide for 2026',
                'category' => 'Education',
                'excerpt' => 'New short courses focused on tech, healthcare, and creative industries are open for enrollment via TESDA training centers.',
                'is_featured' => 0,
            ],
        ];

        $rows = [];
        foreach ($articles as $i => $a) {
            $body = '<p>' . esc($a['excerpt']) . '</p>'
                . '<p>The Philippine government continues its push toward accessible, transparent, and citizen-centered service delivery. SmartCity PH provides a single window to discover, apply for, and track government services from any region.</p>'
                . '<p>For more information, citizens can visit their nearest local government office or browse the Services directory on this portal.</p>';
            $rows[] = [
                'title'        => $a['title'],
                'slug'         => url_title(strtolower($a['title']), '-', true),
                'excerpt'      => $a['excerpt'],
                'body'         => $body,
                'image'        => null,
                'category'     => $a['category'],
                'author'       => 'SmartCity PH Newsroom',
                'tags'         => $a['category'] . ',Philippines,Government',
                'region_id'    => null,
                'is_featured'  => $a['is_featured'],
                'is_published' => 1,
                'published_at' => $now,
                'views'        => rand(120, 2400),
                'created_at'   => $now,
                'updated_at'   => $now,
                'deleted_at'   => null,
            ];
        }
        $this->db->table('news')->insertBatch($rows);
    }
}
