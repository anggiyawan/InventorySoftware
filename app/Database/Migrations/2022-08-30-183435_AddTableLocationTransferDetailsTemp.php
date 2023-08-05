<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableLocationTransferDetailsTemp extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'locationTransferDetailId'	=> [
                'type'           => 'BIGINT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'productId'		=> [
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
			'sourceStock'		=> [
                'type'           => 'INT',
                'constraint'     => '11',
            ],
			'destinationStock'		=> [
                'type'           => 'INT',
                'constraint'     => '11',
            ],
			'transferQuantity'		=> [
                'type'           => 'INT',
                'constraint'     => '11',
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
		
		$this->forge->addForeignKey('productId', 'products', 'productId');
        $this->forge->addPrimaryKey('locationTransferDetailId');
        $this->forge->createTable('location_transfers_details_temp');
		
		$this->db->query("ALTER TABLE location_transfers_details_temp AUTO_INCREMENT 2000000001");
		$this->db->query("CREATE INDEX IDXinputBy ON location_transfers_details_temp(inputBy)");
    }

    public function down()
    {
        $this->forge->dropTable('location_transfers_details_temp');
    }
}
