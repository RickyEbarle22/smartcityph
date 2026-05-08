<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'first_name', 'last_name', 'email', 'password', 'phone',
        'address', 'region_id', 'avatar', 'is_verified', 'is_active', 'last_login',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'first_name' => 'required|max_length[60]',
        'last_name'  => 'required|max_length[60]',
        'email'      => 'required|valid_email|max_length[150]',
    ];

    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    public function withRegion()
    {
        return $this->select('users.*, regions.name as region_name')
            ->join('regions', 'regions.id = users.region_id', 'left');
    }
}
