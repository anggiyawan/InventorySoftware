<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableApprovals extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'	=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
			'option'          => [
                'type'           => 'VARCHAR',
                'constraint'     => "100",
            ],
            'optionId'	=> [
                'type'           => 'INT',
                'constraint'     => 11,
				'unsigned'       => true,
            ],
			'optionName'	=> [
                'type'           => 'VARCHAR',
                'constraint'     => "50",
            ],
            'userId'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'statusId' => [
                'type'           => 'INT',
                'constraint'     => 3,
            ],
			'sort' => [
                'type'           => 'INT',
                'constraint'     => 3,
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
		
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('approvals');
		
		$this->db->query("ALTER TABLE approvals AUTO_INCREMENT 100001");
    }

    public function down()
    {
        $this->forge->dropTable('approvals');
    }
}
