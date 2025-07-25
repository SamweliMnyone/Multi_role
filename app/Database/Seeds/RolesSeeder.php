<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Admin',
                'description' => 'Administrator with full access',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'User',
                'description' => 'Regular user with basic access',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Editor',
                'description' => 'Editor with content management access',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('roles')->insertBatch($data);
    }
}