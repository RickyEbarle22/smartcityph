<?php

namespace App\Models;

use CodeIgniter\Model;

class FeedbackModel extends Model
{
    protected $table            = 'feedback';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'service_id', 'rating', 'comment', 'is_approved'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function approvedForService(int $serviceId)
    {
        return $this->select('feedback.*, users.first_name, users.last_name, users.avatar')
            ->join('users', 'users.id = feedback.user_id', 'left')
            ->where('feedback.service_id', $serviceId)
            ->where('feedback.is_approved', 1)
            ->orderBy('feedback.created_at', 'DESC')
            ->find();
    }

    public function userHasRated(int $userId, int $serviceId): bool
    {
        return (bool) $this->where('user_id', $userId)
            ->where('service_id', $serviceId)
            ->countAllResults();
    }

    public function recalculateService(int $serviceId): void
    {
        $row = $this->select('AVG(rating) as avg_rating, COUNT(*) as total')
            ->where('service_id', $serviceId)
            ->where('is_approved', 1)
            ->first();

        $svc = new ServicesModel();
        $svc->update($serviceId, [
            'avg_rating'    => round((float) ($row['avg_rating'] ?? 0), 2),
            'total_ratings' => (int) ($row['total'] ?? 0),
        ]);
    }
}
