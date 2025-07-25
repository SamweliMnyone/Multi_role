<?php

namespace App\Models;

use CodeIgniter\Model;

class RolePermissionModel extends Model
{
    protected $table = 'role_permissions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['role_id', 'permission_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    public function addPermissionToRole($roleId, $permissionId)
    {
        return $this->insert([
            'role_id' => $roleId,
            'permission_id' => $permissionId,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function removePermissionFromRole($roleId, $permissionId)
    {
        return $this->where('role_id', $roleId)
            ->where('permission_id', $permissionId)
            ->delete();
    }
}