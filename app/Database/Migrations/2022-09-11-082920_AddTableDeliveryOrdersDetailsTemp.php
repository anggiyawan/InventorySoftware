<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableDeliveryOrdersDetailsTemp extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'deliveryOrderDetailId'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'productId'        => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'salesOrderDetailId'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'ordered' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'delivered' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'quantity' => [
                'type'           => 'INT',
                'constraint'     => 11,
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

        $this->forge->addForeignKey('salesOrderDetailId', 'sales_orders_details', 'salesOrderDetailId');
        $this->forge->addPrimaryKey('deliveryOrderDetailId');
        $this->forge->createTable('delivery_orders_details_temp');

        $this->db->query("ALTER TABLE delivery_orders_details_temp AUTO_INCREMENT 2000000001");
        $this->db->query("CREATE INDEX IDXpackageDetailsId ON delivery_orders_details_temp(deliveryOrderDetailId)");
    }

    public function down()
    {
        $this->forge->createTable('delivery_orders_details_temp');
    }
}
