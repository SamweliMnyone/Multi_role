<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function getRolesWithPermissions()
    {
        return $this->select('roles.*, GROUP_CONCAT(permissions.name) as permissions')
            ->join('role_permissions', 'role_permissions.role_id = roles.id', 'left')
            ->join('permissions', 'permissions.id = role_permissions.permission_id', 'left')
            ->groupBy('roles.id')
            ->findAll();
    }

    public function getRolePermissions($roleId)
    {
        return $this->db->table('role_permissions')
            ->select('permissions.*')
            ->join('permissions', 'permissions.id = role_permissions.permission_id')
            ->where('role_permissions.role_id', $roleId)
            ->get()
            ->getResultArray();
    }
}