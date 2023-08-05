<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'groupId'  			=>	"100001",
                'groupName'  		=>  "Administrator",
                'description'  		=>  "Full Access Application",
                'statusId'			=>  1,
                'inputBy'			=>  "100001",
                'inputDate'			=>  date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('groups')->insertBatch($data);
    }
}
