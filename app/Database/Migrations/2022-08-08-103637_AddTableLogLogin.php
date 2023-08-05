<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableLogLogin extends Migration
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
            'ipAddress'				=> [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
            'computer'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
            'userId' => [
                'type'           => 'VARCHAR',
                'constraint'     => '12',
            ],
			'userName' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'version' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
			'inputDate' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ]
        ]);
		
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('LogLogin');
    }

    public function down()
    {
        $this->forge->createTable('log_login');
    }
}
