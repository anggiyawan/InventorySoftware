<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableProducts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'productId'		=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
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
			'remark'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '2000',
            ],
            'statusId' => [
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
		
        $this->forge->addPrimaryKey('productId');
        $this->forge->createTable('products');
		
		$this->db->query("ALTER TABLE products AUTO_INCREMENT 100001");
		$this->db->query("CREATE INDEX IDXproductId ON products(productId)");
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
