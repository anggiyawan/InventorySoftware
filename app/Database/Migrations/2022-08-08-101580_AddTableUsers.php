<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'userId'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'userName'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'fullName'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'email'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'password' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'groupId' => [
                'type'           => 'INT',
                'constraint'     => 11,
				'unsigned'       => true,
            ],
            'statusId' => [
                'type'           => 'INT',
                'constraint'     => '2',
            ],
			'changePassword' => [
                'type'           => 'INT',
                'constraint'     => '1',
            ],
			'deptId' => [
                'type'           => 'VARCHAR',
                'constraint'     => '12',
            ],
			'positionId' => [
                'type'           => 'VARCHAR',
                'constraint'     => '12',
            ],
            'lastLogin' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
			'lastUrl' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
			'site' => [
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
		
		$this->forge->addForeignKey('groupId', 'groups', 'groupId');
        $this->forge->addPrimaryKey('userId');
        $this->forge->createTable('users');
		
		$this->db->query("ALTER TABLE users AUTO_INCREMENT 100001");
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
