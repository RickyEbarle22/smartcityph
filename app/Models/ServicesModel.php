<?php

namespace App\Models;

use CodeIgniter\Model;

class ServicesModel extends Model
{
    protected $table            = 'services';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'slug', 'category', 'short_desc', 'description', 'icon', 'image',
        'requirements', 'steps', 'fee', 'processing_time', 'office', 'contact',
        'website', 'agency', 'region_id', 'is_nationwide', 'is_featured',
        'is_active', 'avg_rating', 'total_ratings',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'name'     => 'required|max_length[150]',
        'category' => 'required|max_length[80]',
    ];

    public function active()
    {
        return $this->where('is_active', 1);
    }

    public function featured(int $limit = 6)
    {
        return $this->select('services.*, regions.name as region_name')
            ->join('regions', 'regions.id = services.region_id', 'left')
            ->where('services.is_featured', 1)
            ->where('services.is_active', 1)
            ->orderBy('services.created_at', 'DESC')
            ->limit($limit)
            ->find();
    }

    public function findBySlug(string $slug)
    {
        return $this->select('services.*, regions.name as region_name')
            ->join('regions', 'regions.id = services.region_id', 'left')
            ->where('services.slug', $slug)
            ->where('services.is_active', 1)
            ->first();
    }

    public function search(?int $regionId = null, ?string $category = null, ?string $q = null)
    {
        $b = $this->select('services.*, regions.name as region_name')
            ->join('regions', 'regions.id = services.region_id', 'left')
            ->where('services.is_active', 1);

        if ($regionId) {
            $b = $b->groupStart()
                ->where('services.region_id', $regionId)
                ->orWhere('services.is_nationwide', 1)
                ->groupEnd();
        }
        if ($category) {
            $b = $b->where('services.category', $category);
        }
        if ($q) {
            $b = $b->groupStart()
                ->like('services.name', $q)
                ->orLike('services.short_desc', $q)
                ->orLike('services.agency', $q)
                ->groupEnd();
        }

        return $b->orderBy('services.is_featured', 'DESC')
            ->orderBy('services.name', 'ASC');
    }

    public function categoryCounts(): array
    {
        $rows = $this->select('category, COUNT(*) as total')
            ->where('is_active', 1)
            ->groupBy('category')
            ->find();

        $counts = [];
        foreach ($rows as $r) {
            $counts[$r['category']] = (int) $r['total'];
        }
        return $counts;
    }
}
