<?php

namespace App\Models;

use CodeIgniter\Model;

class RegionsModel extends Model
{
    protected $table            = 'regions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'slug', 'code', 'type', 'parent_id',
        'latitude', 'longitude', 'population', 'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function active()
    {
        return $this->where('is_active', 1);
    }

    public function regionsOnly()
    {
        return $this->where('type', 'region')->orderBy('name', 'ASC');
    }

    public function findBySlug(string $slug)
    {
        return $this->where('slug', $slug)->first();
    }
}
