<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableAdjustmentsDetails extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'adjustmentDetailId'	=> [
                'type'           => 'BIGINT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
			'adjustmentId'		=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
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
			'AvailableQuantity'	=> [
                'type'           => 'INT',
                'constraint'     => '11',
            ],
			'NewQuantity'		=> [
                'type'           => 'INT',
                'constraint'     => '11',
            ],
			'AdjustedQuantity'	=> [
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
        $this->forge->addPrimaryKey('adjustmentDetailId');
        $this->forge->createTable('adjustments_details');
		
		$this->db->query("ALTER TABLE adjustments_details AUTO_INCREMENT 100001");
		$this->db->query("CREATE INDEX IDXadjustmentDetailId ON adjustments_details(adjustmentDetailId)");
    }

    public function down()
    {
        $this->forge->dropTable('adjustments_details');
    }
}
