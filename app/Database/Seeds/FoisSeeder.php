<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FoisSeeder extends Seeder
{
    public function run()
    {
        if ($this->db->table('fois')->countAllResults() > 0) {
            return;
        }

        $now = date('Y-m-d H:i:s');

        $dpwh = $this->db->table('agencies')->where('acronym', 'DPWH')->get()->getRowArray();
        $dict = $this->db->table('agencies')->where('acronym', 'DICT')->get()->getRowArray();
        $bir  = $this->db->table('agencies')->where('acronym', 'BIR')->get()->getRowArray();

        $samples = [
            [
                'reference'     => 'FOI-' . strtoupper(bin2hex(random_bytes(4))),
                'full_name'     => 'Maria Santos',
                'email'         => 'maria@email.com',
                'phone'         => '+639172234567',
                'agency_id'     => $dict['id'] ?? null,
                'agency_name'   => $dict['name'] ?? 'Department of Information and Communications Technology',
                'request_title' => 'Disbursement records for the National Broadband Program, FY 2024',
                'description'   => "Requesting copies of the quarterly disbursement reports for the National Broadband Program for fiscal year 2024, including amounts released per project site and contractor names. This information is requested for an academic research paper on rural connectivity in the Philippines.",
                'purpose'       => 'Academic research — University of the Philippines',
                'status'        => 'pending',
                'response'      => null,
                'responded_at'  => null,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'reference'     => 'FOI-' . strtoupper(bin2hex(random_bytes(4))),
                'full_name'     => 'Jose Reyes',
                'email'         => 'jose@email.com',
                'phone'         => '+639173234567',
                'agency_id'     => $bir['id'] ?? null,
                'agency_name'   => $bir['name'] ?? 'Bureau of Internal Revenue',
                'request_title' => 'Number of registered freelance professionals by region, 2023',
                'description'   => "Requesting aggregate statistics on the number of self-employed and professional taxpayers (BIR Form 1701/1701A) registered in 2023, broken down by region. No personal identifying information required.",
                'purpose'       => 'Journalism — feature article on freelance economy',
                'status'        => 'fulfilled',
                'response'      => "Aggregate registration data has been provided via email. Please refer to the attached PDF for the regional breakdown.",
                'responded_at'  => $now,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ];

        foreach ($samples as $s) {
            $this->db->table('fois')->insert($s);
        }
    }
}
