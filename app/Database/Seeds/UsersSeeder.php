<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'userId'  			=>	"100001",
                'userName'  		=>  "demo",
                'fullName'  		=>  "demo application",
                'email'  			=>  "demo@gmail.com",
                'password'  		=>  "a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3", // 123
                'groupId'  			=>  "100001",
                'statusId'  		=>  1,
                'changePassword'  	=>  1,
                'deptId'  			=>  "",
                'positionId'  		=>  "",
				'inputBy'			=>  "100001",
                'inputDate'			=>  date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
