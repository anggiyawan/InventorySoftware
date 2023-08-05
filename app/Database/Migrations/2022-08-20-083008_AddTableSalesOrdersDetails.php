<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableSalesOrdersDetails extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'salesOrderDetailId'	=> [
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
			'productId' => [
                'type'           => 'INT',
                'constraint'     => 11,
				'unsigned'       => true,
            ],
			'productNumber'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'productName'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'productType'		=> [
                'type'           => 'INT',
                'constraint'     => '2',
            ],
			'priceCost'		=> [
                'type'           => 'DECIMAL',
                'constraint'     => '10,2',
            ],
			'priceSell'		=> [
                'type'           => 'DECIMAL',
                'constraint'     => '10,2',
            ],
			'amount'		=> [
                'type'           => 'DECIMAL',
                'constraint'     => '10,2',
            ],
			'quantity'		=> [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
			'delivery'		=> [
                'type'           => 'INT',
                'constraint'     => 11,
				'default'		=> 0,
            ],
			'length'		=> [
                'type'           => 'INT',
                'constraint'     => '4',
            ],
			'width'		=> [
                'type'           => 'INT',
                'constraint'     => '4',
            ],
			'height'		=> [
                'type'           => 'INT',
                'constraint'     => '4',
            ],
			'weight'		=> [
                'type'           => 'INT',
                'constraint'     => '11',
            ],
			'unit'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'statusId' => [
                'type'           => 'INT',
                'constraint'     => 2,
            ],
			'sort' => [
                'type'           => 'INT',
                'constraint'     => 3,
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
		
		$this->forge->addForeignKey('salesOrderId', 'sales_orders', 'salesOrderId');
		$this->forge->addForeignKey('productId', 'products', 'productId');
        $this->forge->addPrimaryKey('salesOrderDetailId');
        $this->forge->createTable('sales_orders_details');
		
		$this->db->query("ALTER TABLE sales_orders_details AUTO_INCREMENT 10000000001");
    }

    public function down()
    {
        $this->forge->dropTable('sales_orders_details');
    }
}
