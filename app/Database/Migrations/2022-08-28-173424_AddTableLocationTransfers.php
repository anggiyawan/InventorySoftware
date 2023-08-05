<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableLocationTransfers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'locationTransferId'	=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'reffNumber'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'transferDate' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'remark'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'sourceLocationId'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
			'sourceLocationName'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'destinationLocationId'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
			'destinationLocationName'       => [
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
		
		$this->forge->addForeignKey('sourceLocationId', 'locations', 'locationId');
		$this->forge->addForeignKey('destinationLocationId', 'locations', 'locationId');
        $this->forge->addPrimaryKey('locationTransferId');
        $this->forge->createTable('location_transfers');
		
		$this->db->query("ALTER TABLE location_transfers AUTO_INCREMENT 100001");
		$this->db->query("CREATE INDEX IDXlocationTransferId ON location_transfers(locationTransferId)");
    }

    public function down()
    {
        $this->forge->dropTable('location_transfers');
    }
}
