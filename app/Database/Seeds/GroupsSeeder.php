<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupsSeeder extends Seeder
{
    public function run()
    {
        // Data yang akan di-seed
        $data = [
            [
                'groupId'      => '100001',
                'groupName'    => 'Administrator',
                'description'  => 'Full Access Application',
                'statusId'     => 1,
                'inputBy'      => '100001',
                'inputDate'    => '2022-08-20 18:09:21',
                'updateBy'     => '',
                'updateDate'   => null,
                'deleteBy'     => '',
                'deleteDate'   => null,
            ],
            [
                'groupId'      => '100002',
                'groupName'    => 'STAFF',
                'description'  => 'STAFF',
                'statusId'     => 1,
                'inputBy'      => '100001',
                'inputDate'    => '2022-09-15 13:24:18',
                'updateBy'     => '',
                'updateDate'   => '2022-09-15 13:24:18',
                'deleteBy'     => '',
                'deleteDate'   => null,
            ],
            [
                'groupId'      => '100003',
                'groupName'    => 'SUPPORT',
                'description'  => 'SUPPORT',
                'statusId'     => 1,
                'inputBy'      => '100001',
                'inputDate'    => '2022-10-11 07:44:27',
                'updateBy'     => '',
                'updateDate'   => '2022-10-11 07:44:27',
                'deleteBy'     => '',
                'deleteDate'   => null,
            ],
            [
                'groupId'      => '100004',
                'groupName'    => 'MARKETING',
                'description'  => 'MARKETING',
                'statusId'     => 1,
                'inputBy'      => '100001',
                'inputDate'    => '2022-10-11 07:44:46',
                'updateBy'     => '',
                'updateDate'   => '2022-10-11 07:44:46',
                'deleteBy'     => '',
                'deleteDate'   => null,
            ],
            [
                'groupId'      => '100005',
                'groupName'    => 'WAREHOUSE',
                'description'  => 'WAREHOUSE',
                'statusId'     => 1,
                'inputBy'      => '100001',
                'inputDate'    => '2022-10-11 07:44:55',
                'updateBy'     => '',
                'updateDate'   => '2022-10-11 07:44:55',
                'deleteBy'     => '',
                'deleteDate'   => null,
            ]
        ];

        // Insert data baru
        $this->db->table('groups')->insertBatch($data);
    }
}
