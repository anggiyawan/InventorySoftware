<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableLocationStock extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'locationStockId'	=> [
                'type'           => 'BIGINT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
			'locationId'		=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
			'locationName'		=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
			'productId'		=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
			'stock'		=> [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'remark'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'statusId'       => [
                'type'           => 'INT',
                'constraint'     => 11,
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
		
		$this->forge->addForeignKey('locationId', 'locations', 'locationId');
		$this->forge->addForeignKey('productId', 'products', 'productId');
        $this->forge->addPrimaryKey('locationStockId');
        $this->forge->createTable('location_stock');
		
		$this->db->query("ALTER TABLE location_stock AUTO_INCREMENT 100001");
		$this->db->query("ALTER TABLE `location_stock` ADD UNIQUE `unique_index`(`locationId`, `productId`);");
    }

    public function down()
    {
        $this->forge->dropTable('location_stock');
    }
}
