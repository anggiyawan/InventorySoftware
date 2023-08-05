<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableCustomersStatus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'customerStatusId'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'customerStatusName'	=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'description'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'icon'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'orderBy' => [
                'type'           => 'INT',
                'constraint'     => 2,
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
        $this->forge->addPrimaryKey('customerStatusId');
        $this->forge->createTable('customers_status');
		
		$this->db->query("ALTER TABLE customers_status AUTO_INCREMENT 1");
    }

    public function down()
    {
        $this->forge->dropTable('customers_status');
    }
}
