<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableLocation extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'locationId'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'locationName'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
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
		
        $this->forge->addPrimaryKey('locationId');
        $this->forge->createTable('locations');
		
		$this->db->query("ALTER TABLE locations AUTO_INCREMENT 100001");
    }

    public function down()
    {
        $this->forge->dropTable('locations');
    }
}
