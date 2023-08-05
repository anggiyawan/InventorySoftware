<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTablePackages extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'packageId'	=> [
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
			'ordered' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
			'quantityToPack' => [
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
		
		$this->forge->addForeignKey('salesOrderId', 'sales_orders', 'salesOrderId');
        $this->forge->addPrimaryKey('packageId');
        $this->forge->createTable('packages');
		
		$this->db->query("ALTER TABLE packages AUTO_INCREMENT 100001");
		$this->db->query("CREATE INDEX IDXpackageId ON packages(packageId)");
    }

    public function down()
    {
        $this->forge->createTable('packages');
    }
}
