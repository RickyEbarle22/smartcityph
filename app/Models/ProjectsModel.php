<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectsModel extends Model
{
    protected $table            = 'projects';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title', 'description', 'agency', 'budget', 'status', 'region_id',
        'start_date', 'end_date', 'progress', 'image',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function withRegion()
    {
        return $this->select('projects.*, regions.name as region_name')
            ->join('regions', 'regions.id = projects.region_id', 'left');
    }

    public function totalBudget(): float
    {
        $r = $this->selectSum('budget')->first();
        return (float) ($r['budget'] ?? 0);
    }

    public function statusCounts(): array
    {
        $rows = $this->select('status, COUNT(*) as total')
            ->groupBy('status')
            ->find();
        $counts = ['planned' => 0, 'ongoing' => 0, 'completed' => 0, 'cancelled' => 0];
        foreach ($rows as $r) {
            $counts[$r['status']] = (int) $r['total'];
        }
        return $counts;
    }
}
