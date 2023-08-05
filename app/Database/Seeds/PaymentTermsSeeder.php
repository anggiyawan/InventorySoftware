<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PaymentTermsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'paymentTermId'		=>	100001,
                'termName'  		=>  "Due on reciept",
                'numberOfDay'  		=>  0,
                'statusId'			=>  1,
                'inputBy'			=>  "100001",
                'inputDate'			=>  date('Y-m-d H:i:s'),
            ],
			[
                'paymentTermId'		=>	100002,
                'termName'  		=>  "Due end of the month",
                'numberOfDay'  		=>  0,
                'statusId'			=>  1,
                'inputBy'			=>  "100001",
                'inputDate'			=>  date('Y-m-d H:i:s'),
            ],
			[
                'paymentTermId'		=>	100003,
                'termName'  		=>  "Net 15",
                'numberOfDay'  		=>  15,
                'statusId'			=>  1,
                'inputBy'			=>  "100001",
                'inputDate'			=>  date('Y-m-d H:i:s'),
            ],
			[
                'paymentTermId'		=>	100004,
                'termName'  		=>  "Net 45",
                'numberOfDay'  		=>  45,
                'statusId'			=>  1,
                'inputBy'			=>  "100001",
                'inputDate'			=>  date('Y-m-d H:i:s'),
            ],
			[
                'paymentTermId'		=>	100005,
                'termName'  		=>  "Net 60",
                'numberOfDay'  		=>  45,
                'statusId'			=>  1,
                'inputBy'			=>  "100001",
                'inputDate'			=>  date('Y-m-d H:i:s'),
            ]
			,
			[
                'paymentTermId'		=>	100006,
                'termName'  		=>  "Net 90",
                'numberOfDay'  		=>  90,
                'statusId'			=>  1,
                'inputBy'			=>  "100001",
                'inputDate'			=>  date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('payment_terms')->insertBatch($data);
    }
}
