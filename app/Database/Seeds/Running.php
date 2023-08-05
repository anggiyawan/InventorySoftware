<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Running extends Seeder
{
    public function run()
    {
        $this->call('AutoNumberSeeder');
        $this->call('CustomerStatusSeeder');
        $this->call('GroupsSeeder');
		$this->call('UsersSeeder');
        $this->call('MenuTypeSeeder');
        $this->call('MenuSeeder');
        $this->call('GroupsRolesSeeder');
        $this->call('PaymentTermsSeeder');
    }
}
