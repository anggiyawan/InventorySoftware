<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LocationStockSeeder extends Seeder
{
	public function run()
	{
		$now = date('Y-m-d H:i:s');

		$data = [
			['locationStockId' => 100077, 'locationId' => 100001, 'locationName' => 0, 'productId' => 100001, 'productName' => 'LAPTOP ACER T001', 'stockPhy' => 200, 'stockAcc' => 197, 'remark' => '', 'statusId' => 1, 'inputBy' => '', 'inputDate' => null, 'updateBy' => '', 'updateDate' => '2022-10-17 09:21:42', 'deleteBy' => '', 'deleteDate' => null],
			['locationStockId' => 100078, 'locationId' => 100001, 'locationName' => 0, 'productId' => 100004, 'productName' => 'MSI 001', 'stockPhy' => 1000, 'stockAcc' => 1000, 'remark' => '', 'statusId' => 1, 'inputBy' => '', 'inputDate' => null, 'updateBy' => '', 'updateDate' => '2022-10-02 22:05:08', 'deleteBy' => '', 'deleteDate' => null],
			['locationStockId' => 100084, 'locationId' => 100003, 'locationName' => 0, 'productId' => 100007, 'productName' => 'BLACK SHARK 4', 'stockPhy' => 2500, 'stockAcc' => 2500, 'remark' => '', 'statusId' => 1, 'inputBy' => '', 'inputDate' => null, 'updateBy' => '', 'updateDate' => null, 'deleteBy' => '', 'deleteDate' => null],
			['locationStockId' => 100099, 'locationId' => 100002, 'locationName' => 0, 'productId' => 100007, 'productName' => 'BLACK SHARK 4', 'stockPhy' => 500, 'stockAcc' => 500, 'remark' => '', 'statusId' => 1, 'inputBy' => '', 'inputDate' => null, 'updateBy' => '', 'updateDate' => null, 'deleteBy' => '', 'deleteDate' => null],
			['locationStockId' => 100105, 'locationId' => 100001, 'locationName' => 0, 'productId' => 100007, 'productName' => 'BLACK SHARK 4', 'stockPhy' => 0, 'stockAcc' => 0, 'remark' => '', 'statusId' => 1, 'inputBy' => '', 'inputDate' => null, 'updateBy' => '', 'updateDate' => null, 'deleteBy' => '', 'deleteDate' => null],
			['locationStockId' => 100110, 'locationId' => 100001, 'locationName' => 0, 'productId' => 100008, 'productName' => 'ROG PHONE 5', 'stockPhy' => 699, 'stockAcc' => 700, 'remark' => '', 'statusId' => 1, 'inputBy' => '100001', 'inputDate' => '2022-09-16 07:11:22', 'updateBy' => '', 'updateDate' => '2022-09-16 07:11:22', 'deleteBy' => '', 'deleteDate' => null],
			['locationStockId' => 100112, 'locationId' => 100002, 'locationName' => 0, 'productId' => 100008, 'productName' => 'ROG PHONE 5', 'stockPhy' => 300, 'stockAcc' => 300, 'remark' => '', 'statusId' => 1, 'inputBy' => '', 'inputDate' => null, 'updateBy' => '', 'updateDate' => '2022-10-02 22:31:27', 'deleteBy' => '', 'deleteDate' => null],
			['locationStockId' => 100148, 'locationId' => 100001, 'locationName' => 0, 'productId' => 100006, 'productName' => 'GAMING', 'stockPhy' => 950, 'stockAcc' => 950, 'remark' => '', 'statusId' => 1, 'inputBy' => '', 'inputDate' => null, 'updateBy' => '', 'updateDate' => null, 'deleteBy' => '', 'deleteDate' => null],
			['locationStockId' => 100149, 'locationId' => 100001, 'locationName' => 0, 'productId' => 100003, 'productName' => 'Lenovo Slim 3', 'stockPhy' => 508, 'stockAcc' => 500, 'remark' => '', 'statusId' => 1, 'inputBy' => '', 'inputDate' => null, 'updateBy' => '', 'updateDate' => null, 'deleteBy' => '', 'deleteDate' => null],
			['locationStockId' => 100152, 'locationId' => 100001, 'locationName' => 0, 'productId' => 100009, 'productName' => 'Keyboard Xiaomi M3', 'stockPhy' => 990, 'stockAcc' => 1000, 'remark' => '', 'statusId' => 1, 'inputBy' => '100001', 'inputDate' => '2022-09-19 07:37:28', 'updateBy' => '', 'updateDate' => '2022-09-19 07:37:28', 'deleteBy' => '', 'deleteDate' => null],
			['locationStockId' => 100158, 'locationId' => 100007, 'locationName' => 0, 'productId' => 100006, 'productName' => 'GAMING', 'stockPhy' => 200, 'stockAcc' => 200, 'remark' => '', 'statusId' => 1, 'inputBy' => '', 'inputDate' => null, 'updateBy' => '', 'updateDate' => '2022-10-02 23:15:57', 'deleteBy' => '', 'deleteDate' => null],
			['locationStockId' => 100188, 'locationId' => 100002, 'locationName' => 0, 'productId' => 100001, 'productName' => '', 'stockPhy' => 300, 'stockAcc' => 300, 'remark' => '', 'statusId' => 1, 'inputBy' => '', 'inputDate' => null, 'updateBy' => '', 'updateDate' => null, 'deleteBy' => '', 'deleteDate' => null],
			['locationStockId' => 100199, 'locationId' => 100001, 'locationName' => 0, 'productId' => 100010, 'productName' => '', 'stockPhy' => 1000, 'stockAcc' => 1000, 'remark' => '', 'statusId' => 1, 'inputBy' => '100001', 'inputDate' => '2022-10-11 07:56:22', 'updateBy' => '', 'updateDate' => '2022-10-11 07:56:22', 'deleteBy' => '', 'deleteDate' => null],
		];

		$this->db->query('SET FOREIGN_KEY_CHECKS=0');
		$this->db->query('TRUNCATE TABLE location_stock');
		$this->db->query('ALTER TABLE location_stock AUTO_INCREMENT = 100001');
		$this->db->table('location_stock')->insertBatch($data);
		$this->db->query('SET FOREIGN_KEY_CHECKS=1');
	}
}
