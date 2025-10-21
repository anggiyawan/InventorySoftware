<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupsRolesSeeder extends Seeder
{
	public function run()
	{
		$data = [
			['groupRolesId' => 100001, 'groupId' => 100001, 'menuId' => 100001, 'view' => 1, 'created' => 0, 'updated' => 0, 'cancelled' => 0, 'deleted' => 0, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '100001', 'inputDate' => '2022-08-20 22:18:03'],
			['groupRolesId' => 100002, 'groupId' => 100001, 'menuId' => 100002, 'view' => 1, 'created' => 0, 'updated' => 0, 'cancelled' => 0, 'deleted' => 0, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '100001', 'inputDate' => '2022-08-20 22:18:03'],
			['groupRolesId' => 100003, 'groupId' => 100001, 'menuId' => 100003, 'view' => 1, 'created' => 1, 'updated' => 1, 'cancelled' => 0, 'deleted' => 1, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '100001', 'inputDate' => '2022-08-20 22:18:03'],
			['groupRolesId' => 100004, 'groupId' => 100001, 'menuId' => 100004, 'view' => 1, 'created' => 1, 'updated' => 1, 'cancelled' => 0, 'deleted' => 1, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '100001', 'inputDate' => '2022-08-20 22:18:03'],
			['groupRolesId' => 100005, 'groupId' => 100001, 'menuId' => 100005, 'view' => 1, 'created' => 1, 'updated' => 1, 'cancelled' => 0, 'deleted' => 1, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '100001', 'inputDate' => '2022-08-20 22:18:03'],
			['groupRolesId' => 100006, 'groupId' => 100001, 'menuId' => 100006, 'view' => 1, 'created' => 1, 'updated' => 1, 'cancelled' => 0, 'deleted' => 1, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '100001', 'inputDate' => '2022-08-20 22:18:03'],
			['groupRolesId' => 100007, 'groupId' => 100001, 'menuId' => 100009, 'view' => 1, 'created' => 0, 'updated' => 0, 'cancelled' => 0, 'deleted' => 0, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
			['groupRolesId' => 100008, 'groupId' => 100001, 'menuId' => 100010, 'view' => 1, 'created' => 1, 'updated' => 1, 'cancelled' => 0, 'deleted' => 1, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
			['groupRolesId' => 100009, 'groupId' => 100001, 'menuId' => 100014, 'view' => 1, 'created' => 1, 'updated' => 1, 'cancelled' => 0, 'deleted' => 1, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
			['groupRolesId' => 100010, 'groupId' => 100001, 'menuId' => 100011, 'view' => 1, 'created' => 0, 'updated' => 0, 'cancelled' => 0, 'deleted' => 0, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
			['groupRolesId' => 100011, 'groupId' => 100001, 'menuId' => 100013, 'view' => 1, 'created' => 1, 'updated' => 1, 'cancelled' => 0, 'deleted' => 1, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
			['groupRolesId' => 100012, 'groupId' => 100001, 'menuId' => 100012, 'view' => 1, 'created' => 1, 'updated' => 1, 'cancelled' => 0, 'deleted' => 1, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
			['groupRolesId' => 100013, 'groupId' => 100001, 'menuId' => 100007, 'view' => 1, 'created' => 0, 'updated' => 0, 'cancelled' => 0, 'deleted' => 0, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
			['groupRolesId' => 100014, 'groupId' => 100001, 'menuId' => 100008, 'view' => 1, 'created' => 1, 'updated' => 1, 'cancelled' => 0, 'deleted' => 1, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
			['groupRolesId' => 100015, 'groupId' => 100001, 'menuId' => 100015, 'view' => 0, 'created' => 0, 'updated' => 0, 'cancelled' => 0, 'deleted' => 0, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
			['groupRolesId' => 100016, 'groupId' => 100001, 'menuId' => 100016, 'view' => 0, 'created' => 0, 'updated' => 0, 'cancelled' => 0, 'deleted' => 0, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
			['groupRolesId' => 100017, 'groupId' => 100001, 'menuId' => 100018, 'view' => 1, 'created' => 0, 'updated' => 0, 'cancelled' => 0, 'deleted' => 0, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
			['groupRolesId' => 100018, 'groupId' => 100001, 'menuId' => 100017, 'view' => 1, 'created' => 1, 'updated' => 1, 'cancelled' => 0, 'deleted' => 1, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
			['groupRolesId' => 100019, 'groupId' => 100001, 'menuId' => 100019, 'view' => 1, 'created' => 1, 'updated' => 1, 'cancelled' => 0, 'deleted' => 1, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
			['groupRolesId' => 100020, 'groupId' => 100001, 'menuId' => 100020, 'view' => 1, 'created' => 1, 'updated' => 1, 'cancelled' => 0, 'deleted' => 1, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
			['groupRolesId' => 100021, 'groupId' => 100001, 'menuId' => 100023, 'view' => 1, 'created' => 0, 'updated' => 0, 'cancelled' => 0, 'deleted' => 0, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
			['groupRolesId' => 100022, 'groupId' => 100001, 'menuId' => 100024, 'view' => 1, 'created' => 1, 'updated' => 1, 'cancelled' => 0, 'deleted' => 1, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
			['groupRolesId' => 100023, 'groupId' => 100001, 'menuId' => 100025, 'view' => 1, 'created' => 1, 'updated' => 1, 'cancelled' => 0, 'deleted' => 1, 'printed' => 0, 'downloaded' => 0, 'closed' => 0, 'verified' => 0, 'inputBy' => '', 'inputDate' => null],
		];

		// Kosongkan tabel dan reset auto increment
		$this->db->query('TRUNCATE TABLE groups_roles');
		$this->db->query('ALTER TABLE groups_roles AUTO_INCREMENT = 100001');

		// Insert batch data
		$this->db->table('groups_roles')->insertBatch($data);
	}
}
