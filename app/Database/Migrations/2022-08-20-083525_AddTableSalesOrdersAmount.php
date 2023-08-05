<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableSalesOrdersAmount extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'salesOrderAmountId'          => [
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
			'name'	=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'title'	=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'value'	=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'statusId' => [
                'type'           => 'INT',
                'constraint'     => '2',
				'default'			=> 1,
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
		
		$this->forge->addForeignKey('salesOrderId', 'sales_orders', 'salesOrderId');
        $this->forge->addPrimaryKey('salesOrderAmountId');
        $this->forge->createTable('sales_orders_amount');
		
		$this->db->query("ALTER TABLE sales_orders_amount AUTO_INCREMENT 100001");
    }

    public function down()
    {
        $this->forge->dropTable('sales_orders_amount');
    }
}
