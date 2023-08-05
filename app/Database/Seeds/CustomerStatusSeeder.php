<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerStatusSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'customerStatusId'		=>	1,
                'customerStatusName'	=>  "Active",
                'description'			=>  "",
                'icon'					=>  "green.gif",
                'orderBy'				=>  1,
				'inputBy'				=>  "100001",
                'inputDate'				=>  date('Y-m-d H:i:s'),
            ],
			[
                'customerStatusId'		=>	2,
                'customerStatusName'	=>  "Disable",
                'description'			=>  "",
                'icon'					=>  "red.gif",
                'orderBy'				=>  2,
				'inputBy'				=>  "100001",
                'inputDate'				=>  date('Y-m-d H:i:s'),
            ],
			[
                'customerStatusId'		=>	3,
                'customerStatusName'	=>  "Inactive",
                'description'			=>  "",
                'icon'					=>  "yellow.gif",
                'orderBy'				=>  3,
				'inputBy'				=>  "100001",
                'inputDate'				=>  date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('customers_status')->insertBatch($data);
    }
}
