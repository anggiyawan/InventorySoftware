<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableSalesOrdersAddress extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'salesOrdersAddressId'	=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
			'salesOrderId'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'customerId'	=> [
                'type'           => 'INT',
                'constraint'     => 11,
				'unsigned'       => true,
            ],
			'customerAddressTypeId'	=> [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'country'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'address1' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'address2' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'city' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'state' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'zipCode' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'phone' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'fax' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'statusId' => [
                'type'           => 'INT',
                'constraint'     => 2,
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
		
		$this->forge->addForeignKey('customerId', 'customers', 'customerId');
		$this->forge->addForeignKey('salesOrderId', 'sales_orders', 'salesOrderId');
        $this->forge->addPrimaryKey('salesOrdersAddressId');
        $this->forge->createTable('sales_orders_address');
		
		$this->db->query("ALTER TABLE sales_orders_address AUTO_INCREMENT 100001");
    }

    public function down()
    {
        $this->forge->dropTable('sales_orders_address');
    }
}
