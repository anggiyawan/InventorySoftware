<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaymentTerms extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'paymentTermId'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'termName'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'numberOfDay'		=> [
                'type'           => 'INT',
                'constraint'     => '12',
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
        $this->forge->addPrimaryKey('paymentTermId');
        $this->forge->createTable('payment_terms');
		
		$this->db->query("ALTER TABLE payment_terms AUTO_INCREMENT 100001");
    }

    public function down()
    {
        $this->forge->dropTable('payment_terms');
    }
}
