<?php

namespace App\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $userModel;
    protected $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $user = $this->userModel->getUserWithRole($userId);
        
        // Get user permissions
        $permissions = $this->roleModel->getRolePermissions($user['role_id']);

        $data = [
            'title' => 'Dashboard',
            'user' => $user,
            'permissions' => $permissions,
        ];

        return $this->render('Frontend/Dashboard/index', $data);
    }
}