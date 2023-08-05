<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableLogUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'method'				=> [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
            'description'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '1000',
            ],
            'userId' => [
                'type'           => 'VARCHAR',
                'constraint'     => '12',
            ],
			'inputDate' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ]
        ]);
		
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('log_users');
    }

    public function down()
    {
        $this->forge->dropTable('log_users');
    }
}
