<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // User permissions
            ['name' => 'view_dashboard', 'description' => 'Access to dashboard', 'created_at' => date('Y-m-d H:i:s')],
            
            // Admin permissions
            ['name' => 'manage_users', 'description' => 'Manage all users', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'manage_roles', 'description' => 'Manage all roles', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'manage_permissions', 'description' => 'Manage all permissions', 'created_at' => date('Y-m-d H:i:s')],
            
            // Editor permissions
            ['name' => 'create_content', 'description' => 'Create new content', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'edit_content', 'description' => 'Edit existing content', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'delete_content', 'description' => 'Delete content', 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('permissions')->insertBatch($data);
    }
}