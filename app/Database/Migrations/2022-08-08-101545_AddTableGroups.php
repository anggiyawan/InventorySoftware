<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableGroups extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'groupId'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'groupName'				=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'description'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'statusId' => [
                'type'           => 'INT',
                'constraint'     => '1',
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
        $this->forge->addPrimaryKey('groupId');
        $this->forge->createTable('groups');
		
		$this->db->query("ALTER TABLE groups AUTO_INCREMENT 100001");
    }

    public function down()
    {
        $this->forge->dropTable('groups');
    }
}
