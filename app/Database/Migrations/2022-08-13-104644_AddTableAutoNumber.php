<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableAutoNumber extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'autoId'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'configName'	=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'prefix'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
			'number'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ]
        ]);
        $this->forge->addPrimaryKey('autoId');
        $this->forge->createTable('auto_number');
    }

    public function down()
    {
        $this->forge->dropTable('auto_number');
    }
}
