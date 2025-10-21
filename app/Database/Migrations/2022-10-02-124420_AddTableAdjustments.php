<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableAdjustments extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'adjustmentId'	=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'reffNumber'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'adjustmentDate' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'remark'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
				'null'           => true,
            ],
			'locationId'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
			'locationName'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
				'null'           => true,
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
		
		$this->forge->addForeignKey('locationId', 'locations', 'locationId');
        $this->forge->addPrimaryKey('adjustmentId');
        $this->forge->createTable('adjustments');
		
		$this->db->query("ALTER TABLE adjustments AUTO_INCREMENT 100001");
		$this->db->query("CREATE INDEX IDXadjustmentId ON adjustments(adjustmentId)");
    }

    public function down()
    {
        $this->forge->dropTable('adjustments');
    }
}
