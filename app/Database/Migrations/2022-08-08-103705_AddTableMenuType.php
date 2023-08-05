<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableMenuType extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'menuTypeId'		=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'type'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '12',
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
            ]
        ]);
        $this->forge->addPrimaryKey('menuTypeId');
        $this->forge->createTable('menu_type');
		
		$this->db->query("ALTER TABLE menu_type AUTO_INCREMENT 100001");
    }

    public function down()
    {
        $this->forge->dropTable('menu_type');
    }
}
