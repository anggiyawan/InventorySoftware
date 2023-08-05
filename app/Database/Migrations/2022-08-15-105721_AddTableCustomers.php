<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableCustomers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'customerId'		=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'customerName'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'customerDisplay'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'customerEmail'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'customerPhone'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '20',
            ],
			'customerMobile'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '20',
            ],
			'customerTypeId'		=> [
                'type'           => 'INT',
                'constraint'     => '11',
            ],
			'customerCurrency'	=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
			'website'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
			'remark'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '2000',
            ],
            'statusId' => [
                'type'           => 'INT',
                'constraint'     => 11,
				'unsigned'       => true,
            ],
			'paymentTermId' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'inputBy' => [
                'type'           => 'VARCHAR',
                'constraint'     => '12',
            ],
			'inputDate' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
			'updateBy' => [
                'type'           => 'VARCHAR',
                'constraint'     => '12',
            ],
			'updateDate' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
			'deleteBy' => [
                'type'           => 'VARCHAR',
                'constraint'     => '12',
            ],
			'deleteDate' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ]
        ]);
		
		$this->forge->addForeignKey('statusId', 'customers_status', 'customerStatusId');
		$this->forge->addForeignKey('paymentTermId', 'payment_terms', 'paymentTermId');
        $this->forge->addPrimaryKey('customerId');
        $this->forge->createTable('customers');
		
		$this->db->query("ALTER TABLE customers AUTO_INCREMENT 100001");
    }

    public function down()
    {
        $this->forge->dropTable('customers');
    }
}
