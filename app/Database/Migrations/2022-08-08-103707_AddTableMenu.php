<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableMenu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'menuId'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'menuPid'				=> [
                'type'           => 'INT',
                'constraint'     => '11',
            ],
            'menuTypeId'		=> [
                'type'           => 'INT',
                'constraint'     => 11,
				'unsigned'       => true,
            ],
			'menu'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
			'icon'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
			'url'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
			'urlType'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
			'menuLevel'		=> [
                'type'           => 'INT',
                'constraint'     => '2',
            ],
			'title'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
			'menuOrder'		=> [
                'type'           => 'INT',
                'constraint'     => '6',
            ],
			'statusId'		=> [
                'type'           => 'INT',
                'constraint'     => '2',
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
		$this->forge->addForeignKey('menuTypeId', 'menu_type', 'menuTypeId');
        $this->forge->addPrimaryKey('menuId');
        $this->forge->createTable('menu');
		
		$this->db->query("ALTER TABLE menu AUTO_INCREMENT 100001");
    }

    public function down()
    {
        $this->forge->createTable('menu');
    }
}
