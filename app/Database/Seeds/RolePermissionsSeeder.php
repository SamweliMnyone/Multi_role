<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolePermissionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Admin gets all permissions
            ['role_id' => 1, 'permission_id' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 1, 'permission_id' => 2, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 1, 'permission_id' => 3, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 1, 'permission_id' => 4, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 1, 'permission_id' => 5, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 1, 'permission_id' => 6, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 1, 'permission_id' => 7, 'created_at' => date('Y-m-d H:i:s')],
            
            // User gets basic permissions
            ['role_id' => 2, 'permission_id' => 1, 'created_at' => date('Y-m-d H:i:s')],
            
            // Editor gets content permissions
            ['role_id' => 3, 'permission_id' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 5, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 6, 'created_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'permission_id' => 7, 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('role_permissions')->insertBatch($data);
    }
}