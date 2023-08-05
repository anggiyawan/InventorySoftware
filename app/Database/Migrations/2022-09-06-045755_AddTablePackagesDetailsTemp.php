<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTablePackagesDetailsTemp extends Migration
{
    public function up()
    {
		$this->forge->addField([
            'packageDetailId'	=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'productId'		=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
			'salesOrderDetailId'	=> [
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
		
		$this->forge->addForeignKey('salesOrderDetailId', 'sales_orders_details', 'salesOrderDetailId');
        $this->forge->addPrimaryKey('packageDetailId');
        $this->forge->createTable('packages_details_temp');
		
		$this->db->query("ALTER TABLE packages_details_temp AUTO_INCREMENT 100001");
		$this->db->query("CREATE INDEX IDXpackageDetailsId ON packages_details_temp(packageDetailId)");
    }

    public function down()
    {
        $this->forge->createTable('packages_details_temp');
    }
}
