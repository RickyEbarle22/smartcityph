<?php

namespace App\Models;

use CodeIgniter\Model;

class FoisModel extends Model
{
    protected $table            = 'fois';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'reference', 'full_name', 'email', 'phone', 'agency_id', 'agency_name',
        'request_title', 'description', 'purpose', 'status', 'response', 'responded_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'full_name'     => 'required|max_length[100]',
        'email'         => 'required|valid_email|max_length[150]',
        'request_title' => 'required|max_length[255]',
        'description'   => 'required|min_length[10]',
    ];

    public function findByReference(string $ref)
    {
        return $this->select('fois.*, agencies.name as agency_full_name, agencies.acronym as agency_acronym')
            ->join('agencies', 'agencies.id = fois.agency_id', 'left')
            ->where('fois.reference', $ref)
            ->first();
    }

    public function withAgency()
    {
        return $this->select('fois.*, agencies.name as agency_full_name, agencies.acronym as agency_acronym')
            ->join('agencies', 'agencies.id = fois.agency_id', 'left');
    }

    public function statusCounts(): array
    {
        $rows = $this->select('status, COUNT(*) as total')
            ->groupBy('status')
            ->find();
        $counts = ['pending' => 0, 'processing' => 0, 'fulfilled' => 0, 'denied' => 0];
        foreach ($rows as $r) {
            $counts[$r['status']] = (int) $r['total'];
        }
        return $counts;
    }

    public static function generateReference(): string
    {
        return 'FOI-' . strtoupper(bin2hex(random_bytes(4)));
    }
}
