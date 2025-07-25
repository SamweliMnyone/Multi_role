<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'role_id', 'first_name', 'last_name', 'email', 'password', 'phone', 
        'address', 'profile_pic', 'social_provider', 'social_id', 
        'email_verified_at', 'remember_token', 'status', 'last_login'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    public function getUserWithRole($id)
    {
        return $this->select('users.*, roles.name as role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->where('users.id', $id)
            ->first();
    }
    
    public function getUserBySocialId($provider, $socialId)
    {
        return $this->where('social_provider', $provider)
                   ->where('social_id', $socialId)
                   ->first();
    }
    
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function updateLastLogin($userId)
    {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }
}