<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableGroupRoles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'groupRolesId'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'groupId' => [
                'type'           => 'INT',
                'constraint'     => 11,
				'unsigned'       => true,
            ],
            'menuId'		=> [
                'type'           => 'INT',
                'constraint'     => 11,
				'unsigned'       => true,
            ],
			'view'		=> [
                'type'           => 'INT',
                'constraint'     => '1',
            ],
			'created'		=> [
                'type'           => 'INT',
                'constraint'     => '1',
            ],
			'updated'		=> [
                'type'           => 'INT',
                'constraint'     => '1',
            ],
			'cancelled'		=> [
                'type'           => 'INT',
                'constraint'     => '1',
            ],
			'deleted'		=> [
                'type'           => 'INT',
                'constraint'     => '1',
            ],
			'printed'		=> [
                'type'           => 'INT',
                'constraint'     => '1',
            ],
			'downloaded'		=> [
                'type'           => 'INT',
                'constraint'     => '1',
            ],
			'closed'		=> [
                'type'           => 'INT',
                'constraint'     => '1',
            ],
			'verified'		=> [
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
            ]
        ]);
		$this->forge->addForeignKey('groupId', 'groups', 'groupId');
		$this->forge->addForeignKey('menuId', 'menu', 'menuId');
        $this->forge->addPrimaryKey('groupRolesId');
        $this->forge->createTable('groups_roles');
    }

    public function down()
    {
        $this->forge->dropTable('groups_roles');
    }
}
