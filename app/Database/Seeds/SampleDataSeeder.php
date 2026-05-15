<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        if ($this->db->table('admins')->where('username', 'admin')->countAllResults() > 0) {
            return; // sample data already loaded
        }
        $now = date('Y-m-d H:i:s');

        // ── Admin ─────────────────────────────────────────
        $this->db->table('admins')->insert([
            'username'   => 'admin',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'full_name'  => 'SmartCity PH Administrator',
            'email'      => 'admin@smartcityph.gov.ph',
            'role'       => 'superadmin',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ── Citizens ─────────────────────────────────────
        $ncr = $this->db->table('regions')->where('slug', 'ncr')->get()->getRowArray();
        $r7  = $this->db->table('regions')->where('slug', 'region-7')->get()->getRowArray();

        $users = [
            ['Juan',    'Dela Cruz',    'juan@email.com',    'citizen123', '+639171234567', 'Quezon City',   $ncr['id'] ?? null],
            ['Maria',   'Santos',       'maria@email.com',   'citizen123', '+639172234567', 'Cebu City',     $r7['id']  ?? null],
            ['Jose',    'Reyes',        'jose@email.com',    'citizen123', '+639173234567', 'Manila',        $ncr['id'] ?? null],
        ];
        foreach ($users as $u) {
            $this->db->table('users')->insert([
                'first_name'  => $u[0],
                'last_name'   => $u[1],
                'email'       => $u[2],
                'password'    => password_hash($u[3], PASSWORD_DEFAULT),
                'phone'       => $u[4],
                'address'     => $u[5],
                'region_id'   => $u[6],
                'is_verified' => 1,
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }

        // ── Reports ─────────────────────────────────────
        $sampleReports = [
            ['Pothole on EDSA southbound near Ortigas',    'Road',         'high',    'pending',     14.5828, 121.0573, $ncr['id'] ?? null],
            ['Uncollected garbage along España Boulevard', 'Garbage',      'medium',  'reviewing',   14.6090, 120.9889, $ncr['id'] ?? null],
            ['Flooding in Brgy. Gun-ob, Lapu-Lapu City',   'Flooding',     'urgent',  'in_progress', 10.3104, 123.9477, $r7['id']  ?? null],
            ['Streetlight outage on Katipunan Avenue',     'Streetlight',  'low',     'resolved',    14.6353, 121.0712, $ncr['id'] ?? null],
            ['Loud music at 2AM in Brgy. Mabuhay',         'Noise',        'low',     'rejected',    14.5547, 121.0244, $ncr['id'] ?? null],
        ];
        foreach ($sampleReports as $r) {
            $this->db->table('reports')->insert([
                'reference'   => 'RPT-' . strtoupper(bin2hex(random_bytes(4))),
                'user_id'     => 1,
                'full_name'   => 'Juan Dela Cruz',
                'email'       => 'juan@email.com',
                'phone'       => '+639171234567',
                'category'    => $r[1],
                'location'    => $r[0],
                'description' => 'Reported via SmartCity PH portal. ' . $r[0],
                'latitude'    => $r[4],
                'longitude'   => $r[5],
                'region_id'   => $r[6],
                'status'      => $r[3],
                'priority'    => $r[2],
                'admin_notes' => $r[3] === 'resolved' ? 'Issue has been addressed by the local government unit.' : null,
                'resolved_at' => $r[3] === 'resolved' ? $now : null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }

        // ── Projects ─────────────────────────────────────
        $projects = [
            ['Metro Manila Subway Project — Phase 1', 'DOTr', 488000000000, 'ongoing',   35, $ncr['id'] ?? null],
            ['North-South Commuter Railway',          'DOTr', 880000000000, 'ongoing',   55, $ncr['id'] ?? null],
            ['Cebu BRT System',                       'DPWH',  16310000000, 'ongoing',   42, $r7['id']  ?? null],
            ['Build Better More — Rural Health',      'DOH',   75000000000, 'planned',   10, null],
            ['e-Government Master Plan 2028',         'DICT',  19200000000, 'ongoing',   62, null],
        ];
        foreach ($projects as $p) {
            $this->db->table('projects')->insert([
                'title'       => $p[0],
                'description' => 'Flagship Philippine government infrastructure and services project under Build Better More.',
                'agency'      => $p[1],
                'budget'      => $p[2],
                'status'      => $p[3],
                'region_id'   => $p[5],
                'start_date'  => '2024-01-01',
                'end_date'    => '2028-12-31',
                'progress'    => $p[4],
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }

        // ── Feedback ─────────────────────────────────────
        $services = $this->db->table('services')->limit(5)->get()->getResultArray();
        foreach ($services as $i => $svc) {
            $rating = 5 - ($i % 2);
            $this->db->table('feedback')->insert([
                'user_id'     => 1,
                'service_id'  => $svc['id'],
                'rating'      => $rating,
                'comment'     => 'Very helpful and easy to follow. Thank you SmartCity PH!',
                'is_approved' => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
            $this->db->table('services')->where('id', $svc['id'])->update([
                'avg_rating'    => $rating,
                'total_ratings' => 1,
            ]);
        }
    }
}
