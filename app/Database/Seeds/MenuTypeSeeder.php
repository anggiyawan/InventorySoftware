<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuTypeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'menuTypeId'	=>	100001,
                'type'			=>  "MENU PRIMARY",
                'inputBy'		=>  "100001",
                'inputDate'		=>  date('Y-m-d H:i:s'),
            ],
			[
                'menuTypeId'	=>	100002,
                'type'			=>  "TOP MENU",
                'inputBy'		=>  "100001",
                'inputDate'		=>  date('Y-m-d H:i:s'),
            ],
			[
                'menuTypeId'	=>	100003,
                'type'			=>  "MENU BLOG",
                'inputBy'		=>  "100001",
                'inputDate'		=>  date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('menu_type')->insertBatch($data);
    }
}
