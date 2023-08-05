<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableDeliveryOrders extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'deliveryOrderId'	=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'salesOrderId'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
			'deliveryOrderNumber'	=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'shipmentDate' => [
                'type'           => 'DATETIME',
                'null'           => false,
            ],
			'deliveryDate' => [
                'type'           => 'DATETIME',
                'null'           => false,
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
			'sourceLocationId'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'remark'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'statusId'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
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
		$this->forge->addForeignKey('sourceLocationId', 'locations', 'locationId');
        $this->forge->addPrimaryKey('deliveryOrderId');
        $this->forge->createTable('delivery_orders');
		
		$this->db->query("ALTER TABLE delivery_orders AUTO_INCREMENT 100001");
		$this->db->query("CREATE INDEX IDXdeliveryOrderId ON delivery_orders(deliveryOrderId)");
    }

    public function down()
    {
        $this->forge->createTable('delivery_orders');
    }
}
