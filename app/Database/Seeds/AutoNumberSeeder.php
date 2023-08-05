<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AutoNumberSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'autoId'  			=>	100001,
                'configName'  		=>  "SALES_ORDER_NUMBER",
                'prefix'			=>  "SO-",
                'number'			=>  100000,
            ],
			[
                'autoId'  			=>	100002,
                'configName'  		=>  "TRANSFER_LOCATION",
                'prefix'			=>  "LT-",
                'number'			=>  100000,
            ],
			[
                'autoId'  			=>	100003,
                'configName'  		=>  "PACKING_SLIP",
                'prefix'			=>  "PKG-",
                'number'			=>  100000,
            ],
			[
                'autoId'  			=>	100004,
                'configName'  		=>  "DELIVERY_ORDER",
                'prefix'			=>  "DO-",
                'number'			=>  100000,
            ],
			[
                'autoId'  			=>	100005,
                'configName'  		=>  "ADJUSTMENT",
                'prefix'			=>  "AJ-",
                'number'			=>  100000,
            ],
        ];
        $this->db->table('auto_number')->insertBatch($data);
    }
}
