<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table            = 'news';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title', 'slug', 'excerpt', 'body', 'image', 'category', 'author',
        'tags', 'region_id', 'is_featured', 'is_published', 'published_at', 'views',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'title'    => 'required|max_length[255]',
        'category' => 'required|max_length[80]',
    ];

    public function published()
    {
        return $this->where('is_published', 1);
    }

    public function findBySlug(string $slug)
    {
        return $this->where('slug', $slug)->where('is_published', 1)->first();
    }

    public function latest(int $limit = 3)
    {
        return $this->where('is_published', 1)
            ->orderBy('published_at', 'DESC')
            ->limit($limit)
            ->find();
    }

    public function featured()
    {
        return $this->where('is_featured', 1)
            ->where('is_published', 1)
            ->orderBy('published_at', 'DESC')
            ->first();
    }

    public function incrementViews(int $id)
    {
        $this->set('views', 'views + 1', false)->where('id', $id)->update();
    }
}
