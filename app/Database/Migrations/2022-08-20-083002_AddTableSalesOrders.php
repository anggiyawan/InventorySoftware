<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableSalesOrders extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'salesOrderId'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'salesOrderNumber'	=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'salesOrderDate'	=> [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
			'expectedShipmentDate'	=> [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
			'shipmentDate'	=> [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
			'reference'	=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'customerId'	=> [
                'type'           => 'INT',
                'constraint'     => 11,
				'unsigned'       => true,
				'unique'		=> false,
            ],
			'customerName'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'customerDisplay'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'representativeId'	=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
				'null'			=> TRUE,
            ],
            'representative'	=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'totalAmount'		=> [
                'type'			=> 'DECIMAL',
                'constraint'	=> '10,2',
				'null'			=> FALSE,
				'default'		=> 0.00
            ],
			'paymentTermId' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
			'termName'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'remark'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'statusId' => [
                'type'           => 'INT',
                'constraint'     => '2',
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
		$this->forge->addForeignKey('paymentTermId', 'payment_terms', 'paymentTermId');
		$this->forge->addForeignKey('representativeId', 'representative', 'representativeId');
        $this->forge->addPrimaryKey('salesOrderId');
        $this->forge->createTable('sales_orders');
		
		$this->db->query("ALTER TABLE sales_orders AUTO_INCREMENT 100001");
    }

    public function down()
    {
        $this->forge->dropTable('sales_orders');
    }
}
