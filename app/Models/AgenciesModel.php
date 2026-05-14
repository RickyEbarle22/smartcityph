<?php

namespace App\Models;

use CodeIgniter\Model;

class AgenciesModel extends Model
{
    protected $table            = 'agencies';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'slug', 'acronym', 'description', 'category', 'website',
        'email', 'phone', 'address', 'logo', 'head_name', 'head_title', 'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name' => 'required|max_length[150]',
    ];

    public function active()
    {
        return $this->where('is_active', 1);
    }

    public function findBySlug(string $slug)
    {
        return $this->where('slug', $slug)->where('is_active', 1)->first();
    }

    public function categories(): array
    {
        $rows = $this->select('category')
            ->where('is_active', 1)
            ->where('category IS NOT NULL')
            ->groupBy('category')
            ->orderBy('category', 'ASC')
            ->find();

        return array_filter(array_map(static fn ($r) => $r['category'] ?? null, $rows));
    }

    public function search(?string $q = null, ?string $category = null)
    {
        $b = $this->where('is_active', 1);
        if ($q) {
            $b = $b->groupStart()
                ->like('name', $q)
                ->orLike('acronym', $q)
                ->orLike('description', $q)
                ->groupEnd();
        }
        if ($category) {
            $b = $b->where('category', $category);
        }
        return $b->orderBy('name', 'ASC');
    }
}
