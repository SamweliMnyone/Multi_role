<?php

namespace App\Controllers;

use App\Models\PermissionModel;
use App\Models\RoleModel;
use App\Models\RolePermissionModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $permissionModel;
    protected $rolePermissionModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->permissionModel = new PermissionModel();
        $this->rolePermissionModel = new RolePermissionModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Admin Dashboard',
            'userCount' => $this->userModel->countAll(),
            'roleCount' => $this->roleModel->countAll(),
            'permissionCount' => $this->permissionModel->countAll(),
        ];

        return $this->render('Frontend/Admin/index', $data);
    }

    // User Management
    public function users()
    {
        $users = $this->userModel->select('users.*, roles.name as role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->findAll();

        $data = [
            'title' => 'Manage Users',
            'users' => $users,
        ];

        return $this->render('Frontend/Admin/Users/index', $data);
    }

    public function createUser()
    {
        $roles = $this->roleModel->findAll();

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'first_name' => 'required|min_length[2]|max_length[100]',
                'last_name' => 'required|min_length[2]|max_length[100]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]',
                'role_id' => 'required|numeric',
                'status' => 'required|in_list[active,inactive,suspended]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $userData = [
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'role_id' => $this->request->getPost('role_id'),
                'status' => $this->request->getPost('status'),
            ];

            if ($this->userModel->save($userData)) {
                return redirect()->to('/admin/users')->with('message', 'User created successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to create user');
            }
        }

        $data = [
            'title' => 'Create User',
            'roles' => $roles,
        ];

        return $this->render('Frontend/Admin/Users/create', $data);
    }

    public function editUser($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User not found');
        }

        $roles = $this->roleModel->findAll();

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'first_name' => 'required|min_length[2]|max_length[100]',
                'last_name' => 'required|min_length[2]|max_length[100]',
                'email' => "required|valid_email|is_unique[users.email,id,$id]",
                'role_id' => 'required|numeric',
                'status' => 'required|in_list[active,inactive,suspended]',
            ];

            // Only validate password if it's provided
            if ($this->request->getPost('password')) {
                $rules['password'] = 'min_length[8]';
            }

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $userData = [
                'id' => $id,
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'email' => $this->request->getPost('email'),
                'role_id' => $this->request->getPost('role_id'),
                'status' => $this->request->getPost('status'),
            ];

            // Only update password if it's provided
            if ($this->request->getPost('password')) {
                $userData['password'] = $this->request->getPost('password');
            }

            if ($this->userModel->save($userData)) {
                return redirect()->to('/admin/users')->with('message', 'User updated successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update user');
            }
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => $roles,
        ];

        return $this->render('Frontend/Admin/Users/edit', $data);
    }

    public function deleteUser($id)
    {
        if ($this->userModel->delete($id)) {
            return redirect()->to('/admin/users')->with('message', 'User deleted successfully');
        } else {
            return redirect()->to('/admin/users')->with('error', 'Failed to delete user');
        }
    }

    // Role Management
    public function roles()
    {
        $roles = $this->roleModel->getRolesWithPermissions();

        $data = [
            'title' => 'Manage Roles',
            'roles' => $roles,
        ];

        return $this->render('Frontend/Admin/Roles/index', $data);
    }

    public function createRole()
    {
        $permissions = $this->permissionModel->findAll();

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[2]|max_length[100]|is_unique[roles.name]',
                'description' => 'permit_empty|max_length[255]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $roleData = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
            ];

            if ($roleId = $this->roleModel->insert($roleData)) {
                // Add selected permissions
                $selectedPermissions = $this->request->getPost('permissions') ?? [];
                foreach ($selectedPermissions as $permissionId) {
                    $this->rolePermissionModel->addPermissionToRole($roleId, $permissionId);
                }

                return redirect()->to('/admin/roles')->with('message', 'Role created successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to create role');
            }
        }

        $data = [
            'title' => 'Create Role',
            'permissions' => $permissions,
        ];

        return $this->render('Frontend/Admin/Roles/create', $data);
    }

    public function editRole($id)
    {
        $role = $this->roleModel->find($id);
        if (!$role) {
            return redirect()->to('/admin/roles')->with('error', 'Role not found');
        }

        $permissions = $this->permissionModel->findAll();
        $rolePermissions = $this->roleModel->getRolePermissions($id);
        $assignedPermissionIds = array_column($rolePermissions, 'id');

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => "required|min_length[2]|max_length[100]|is_unique[roles.name,id,$id]",
                'description' => 'permit_empty|max_length[255]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $roleData = [
                'id' => $id,
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
            ];

            if ($this->roleModel->save($roleData)) {
                // Update permissions
                $selectedPermissions = $this->request->getPost('permissions') ?? [];
                
                // First, remove all existing permissions for this role
                $this->rolePermissionModel->where('role_id', $id)->delete();
                
                // Then add the selected permissions
                foreach ($selectedPermissions as $permissionId) {
                    $this->rolePermissionModel->addPermissionToRole($id, $permissionId);
                }

                return redirect()->to('/admin/roles')->with('message', 'Role updated successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update role');
            }
        }

        $data = [
            'title' => 'Edit Role',
            'role' => $role,
            'permissions' => $permissions,
            'assignedPermissionIds' => $assignedPermissionIds,
        ];

        return $this->render('Frontend/Admin/Roles/edit', $data);
    }

    public function deleteRole($id)
    {
        // Check if any users are assigned to this role
        $usersWithRole = $this->userModel->where('role_id', $id)->countAllResults();
        
        if ($usersWithRole > 0) {
            return redirect()->to('/admin/roles')->with('error', 'Cannot delete role assigned to users');
        }

        // First delete role permissions
        $this->rolePermissionModel->where('role_id', $id)->delete();
        
        // Then delete the role
        if ($this->roleModel->delete($id)) {
            return redirect()->to('/admin/roles')->with('message', 'Role deleted successfully');
        } else {
            return redirect()->to('/admin/roles')->with('error', 'Failed to delete role');
        }
    }

    // Permission Management
    public function permissions()
    {
        $permissions = $this->permissionModel->findAll();

        $data = [
            'title' => 'Manage Permissions',
            'permissions' => $permissions,
        ];

        return $this->render('Frontend/Admin/Permissions/index', $data);
    }

    public function createPermission()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[2]|max_length[100]|is_unique[permissions.name]',
                'description' => 'permit_empty|max_length[255]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $permissionData = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
            ];

            if ($this->permissionModel->save($permissionData)) {
                return redirect()->to('/admin/permissions')->with('message', 'Permission created successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to create permission');
            }
        }

        $data = [
            'title' => 'Create Permission',
        ];

        return $this->render('Frontend/Admin/Permissions/create', $data);
    }

    public function editPermission($id)
    {
        $permission = $this->permissionModel->find($id);
        if (!$permission) {
            return redirect()->to('/admin/permissions')->with('error', 'Permission not found');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => "required|min_length[2]|max_length[100]|is_unique[permissions.name,id,$id]",
                'description' => 'permit_empty|max_length[255]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $permissionData = [
                'id' => $id,
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
            ];

            if ($this->permissionModel->save($permissionData)) {
                return redirect()->to('/admin/permissions')->with('message', 'Permission updated successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update permission');
            }
        }

        $data = [
            'title' => 'Edit Permission',
            'permission' => $permission,
        ];

        return $this->render('Frontend/Admin/Permissions/edit', $data);
    }

    public function deletePermission($id)
    {
        // Check if permission is assigned to any roles
        $assignedToRoles = $this->rolePermissionModel->where('permission_id', $id)->countAllResults();
        
        if ($assignedToRoles > 0) {
            return redirect()->to('/admin/permissions')->with('error', 'Cannot delete permission assigned to roles');
        }

        if ($this->permissionModel->delete($id)) {
            return redirect()->to('/admin/permissions')->with('message', 'Permission deleted successfully');
        } else {
            return redirect()->to('/admin/permissions')->with('error', 'Failed to delete permission');
        }
    }
}