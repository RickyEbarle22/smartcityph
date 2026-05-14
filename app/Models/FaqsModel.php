<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqsModel extends Model
{
    protected $table            = 'faqs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'question', 'answer', 'category', 'sort_order', 'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'question' => 'required',
        'answer'   => 'required',
    ];

    public function active()
    {
        return $this->where('is_active', 1)->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC');
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
                ->like('question', $q)
                ->orLike('answer', $q)
                ->groupEnd();
        }
        if ($category) {
            $b = $b->where('category', $category);
        }
        return $b->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC');
    }
}
