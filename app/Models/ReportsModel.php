<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportsModel extends Model
{
    protected $table            = 'reports';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'reference', 'user_id', 'full_name', 'email', 'phone', 'category',
        'location', 'description', 'latitude', 'longitude', 'image', 'region_id',
        'status', 'priority', 'admin_notes', 'assigned_to', 'resolved_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'full_name'   => 'required|max_length[100]',
        'email'       => 'required|valid_email',
        'category'    => 'required|max_length[60]',
        'location'    => 'required|max_length[255]',
        'description' => 'required|min_length[10]',
    ];

    public function findByReference(string $ref)
    {
        return $this->select('reports.*, regions.name as region_name')
            ->join('regions', 'regions.id = reports.region_id', 'left')
            ->where('reports.reference', $ref)
            ->first();
    }

    public function generateReference(): string
    {
        return 'RPT-' . strtoupper(bin2hex(random_bytes(4)));
    }

    public function withDetails()
    {
        return $this->select('reports.*, regions.name as region_name, users.first_name, users.last_name')
            ->join('regions', 'regions.id = reports.region_id', 'left')
            ->join('users', 'users.id = reports.user_id', 'left');
    }

    public function statusCounts(): array
    {
        $rows = $this->select('status, COUNT(*) as total')
            ->groupBy('status')
            ->find();

        $counts = [
            'pending' => 0, 'reviewing' => 0, 'in_progress' => 0,
            'resolved' => 0, 'rejected' => 0,
        ];
        foreach ($rows as $r) {
            $counts[$r['status']] = (int) $r['total'];
        }
        return $counts;
    }
}
