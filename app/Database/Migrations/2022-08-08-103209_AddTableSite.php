<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableSite extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'siteId'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'site'				=> [
                'type'           => 'VARCHAR',
                'constraint'     => '12',
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
        $this->forge->addPrimaryKey('siteId');
        $this->forge->createTable('site');
    }

    public function down()
    {
        $this->forge->dropTable('site');
    }
}
