<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableCustomersAddress extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'customerAddressId'	=> [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'customerId'	=> [
                'type'           => 'INT',
                'constraint'     => 11,
				'unsigned'       => true,
				'unique'		=> false,
            ],
			'customerAddressTypeId'	=> [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'country'		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'address1' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'address2' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'city' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'state' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'zipCode' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'phone' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'fax' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
			'statusId' => [
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
		$this->forge->addForeignKey('customerId', 'customers', 'customerId');
        $this->forge->addPrimaryKey('customerAddressId');
        $this->forge->createTable('customers_address');
		
		$this->db->query("ALTER TABLE customers_address AUTO_INCREMENT 100001");
    }

    public function down()
    {
        $this->forge->dropTable('customers_address');
    }
}
