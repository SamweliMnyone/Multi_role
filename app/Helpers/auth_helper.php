<?php

if (!function_exists('has_permission')) {
    function has_permission($permissionName)
    {
        $userModel = new \App\Models\UserModel();
        $roleModel = new \App\Models\RoleModel();
        
        $userId = session()->get('user_id');
        if (!$userId) return false;
        
        $user = $userModel->find($userId);
        if (!$user) return false;
        
        $permissions = $roleModel->getRolePermissions($user['role_id']);
        
        foreach ($permissions as $permission) {
            if ($permission['name'] === $permissionName) {
                return true;
            }
        }
        
        return false;
    }
}

if (!function_exists('is_admin')) {
    function is_admin()
    {
        return session()->get('role_id') == 1;
    }
}