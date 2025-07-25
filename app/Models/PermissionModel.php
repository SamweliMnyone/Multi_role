<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function getPermissionsNotInRole($roleId)
    {
        $subquery = $this->db->table('role_permissions')
            ->select('permission_id')
            ->where('role_id', $roleId);

        return $this->whereNotIn('id', $subquery)
            ->findAll();
    }
}