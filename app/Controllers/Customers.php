<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Customers extends BaseController
{
	public function __construct()
	{
		$this->db		= \Config\Database::connect();
		// $this->request	= \Config\Services::request();
		$this->session	= \Config\Services::session();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{
		//
	}

	public function manage()
	{
		return view('customers/customers');
	}

	public function getJson()
	{
		// header('Content-Type: application/json');

		// get model table
		$customersModel = new \App\Models\CustomersModel();
		$customersAddressModel = new \App\Models\CustomersAddressModel();

		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'customerId';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'desc';
		$offset = ($page - 1) * $rows;

		$result = array();
		$result['total'] = $customersModel->getCount();
		$row = array();

		$criteria = $customersModel->getAll(array("sort" => $sort, "order" => $order, "offset" => $offset, "rows" => $rows));

		foreach ($criteria as $data) {
			if ($data->statusId == \CUSTOMERS::ACTIVE) {
				$status = "<div class='circle green'></div> Active";
			} else if ($data->statusId == \CUSTOMERS::DISABLED) {
				$status = "<div class='circle red'></div> Disable";
			}

			if ($data->customerTypeId == \CUSTOMER_TYPE::BUSINESS) {
				$customerType = "Business";
			} else if ($data->customerTypeId == \CUSTOMER_TYPE::INDIVIDUAL) {
				$customerType = "Individual";
			}

			$row[] = array(
				'customerId'		=> $data->customerId,
				'customerName'		=> $data->customerName,
				'customerDisplay'	=> $data->customerDisplay,
				'customerEmail'		=> $data->customerEmail,
				'customerPhone'		=> $data->customerPhone,
				'customerMobile'	=> $data->customerMobile,
				'customerType'		=> $customerType,
				'customerTypeId'	=> $data->customerTypeId,
				'customerWebsite'	=> $data->website,
				'customerCurrency'	=> "Rp",
				'customerRemark'	=> $data->remark,
				'paymentTerm'		=> $data->termName,
				'paymentTermId'		=> $data->paymentTermId,
				'status'			=> $status,
				'customerStatusId'	=> $data->statusId,
				'inputBy'			=> $data->inputBy,
				'inputDate'			=> date('Y-m-d', strtotime($data->inputDate)),
				'updateBy'			=> $data->updateBy,
				'updateDate'		=> date('Y-m-d', strtotime($data->updateDate)),

				'addressBillCountry'	=> $data->billCountry,
				'addressBillStreet1'	=> $data->billAddress1,
				'addressBillStreet2'	=> $data->billAddress2,
				'addressBillCity'		=> $data->billCity,
				'addressBillState'		=> $data->billState,
				'addressBillZipCode'	=> $data->billZipCode,
				'addressBillPhone'		=> $data->billPhone,
				'addressBillFax'		=> $data->billFax,

				'addressShipCountry'	=> $data->shipCountry,
				'addressShipStreet1'	=> $data->shipAddress1,
				'addressShipStreet2'	=> $data->shipAddress2,
				'addressShipCity'		=> $data->shipCity,
				'addressShipState'		=> $data->shipState,
				'addressShipZipCode'	=> $data->shipZipCode,
				'addressShipPhone'		=> $data->shipPhone,
				'addressShipFax'		=> $data->shipFax,
			);

			// $addresses = $customersAddressModel->where(array('statusId' => 1, 'customerId' => '100010'))->findAll();
			// $addresses = $customersAddressModel->where('statusId', 1)->findAll();
			// var_dump($address);
			// foreach($addresses as $address)
			// {
			// $test = array(
			// 'country' => $address->country,
			// );

			// $row=array_merge($row,$test);
			// }

		}
		$result = array_merge($result, array('rows' => $row));
		return json_encode($result);
	}

	public function createCustomers()
	{
		header('Content-Type: application/json');

		// get model table
		$customersModel = new \App\Models\CustomersModel();
		$customersAddressModel = new \App\Models\CustomersAddressModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			// $this->validation->setRules([
			// "userName" 	=> ["label" => "*Name*", "rules" => "required|min_length[3]|max_length[255]"],
			// "fullName" 	=> ["label" => "*Full Name*", "rules" => "required|min_length[3]|max_length[255]"],
			// "email" 	=> ["label" => "*Email*", "rules" => "valid_email|min_length[3]|max_length[255]"],
			// ]);

			// if(!$this->validation->withRequest($this->request)->run()){
			// foreach ($this->validation->getErrors() as $error) {}
			// throw new \Exception($error);
			// }

			// $userId = addslashes($this->request->getPost("userId"));
			$this->db->transBegin();
			// insert customers
			$paramInsert = array(
				// 'customerId'			=> $customersModel->autoCustomersId('customerId'),
				'customerTypeId'		=> $this->request->getPost("customerTypeId"),
				'customerName'			=> strtoupper($this->request->getPost("customerName")),
				'customerDisplay'		=> strtoupper($this->request->getPost("customerDisplay")),
				'customerEmail'			=> $this->request->getPost("customerEmail"),
				'customerPhone'			=> $this->request->getPost("customerPhone"),
				'customerMobile'		=> $this->request->getPost("customerMobile"),
				'customerCurrency'		=> $this->request->getPost("customerCurrency"),
				'paymentTermId'			=> $this->request->getPost("paymentTermId"),
				'website'				=> $this->request->getPost("customerWebsite"),
				'remark'				=> $this->request->getPost("customerRemark"),
				'statusId'				=> $this->request->getPost("customerStatusId"),
				'inputBy'				=> $this->session->get("userId"),
			);
			$customersModel->insert($paramInsert);
			// insert customers EOF

			// insert billingAddress
			$paramAddressBill = array(
				'customerId'		=> $customersModel->getInsertID(),
				'customerAddressTypeId'	=> \CUSTOMER_ADDRESS_TYPE::BILLING_ADDRESS,
				'country'			=> "ID", //$this->request->getPost("addressBillCountry"),
				'address1'			=> $this->request->getPost("addressBillStreet1"),
				'address2'			=> $this->request->getPost("addressBillStreet2"),
				'city'				=> $this->request->getPost("addressBillCity"),
				'state'				=> $this->request->getPost("addressBillState"),
				'zipCode'			=> $this->request->getPost("addressBillZipCode"),
				'phone'				=> $this->request->getPost("addressBillPhone"),
				'fax'				=> $this->request->getPost("addressBillFax"),
				'statusId'			=> \CUSTOMER_ADDRESS_STATUS::PRIMARY,
				'inputBy'			=> $this->session->get("userId"),
			);
			$customersAddressModel->insert($paramAddressBill);
			// insert billingAddress EOF

			// insert shippingAddress
			$paramAddressShip = array(
				'customerId'		=> $customersModel->getInsertID(),
				'customerAddressTypeId'	=> \CUSTOMER_ADDRESS_TYPE::SHIPPING_ADDRESS,
				'country'			=> "ID", //$this->request->getPost("addressShipCountry"),
				'address1'			=> $this->request->getPost("addressShipStreet1"),
				'address2'			=> $this->request->getPost("addressShipStreet2"),
				'city'				=> $this->request->getPost("addressShipCity"),
				'state'				=> $this->request->getPost("addressShipState"),
				'zipCode'			=> $this->request->getPost("addressShipZipCode"),
				'phone'				=> $this->request->getPost("addressShipPhone"),
				'fax'				=> $this->request->getPost("addressShipFax"),
				'statusId'			=> \CUSTOMER_ADDRESS_STATUS::PRIMARY,
				'inputBy'			=> $this->session->get("userId"),
			);
			$customersAddressModel->insert($paramAddressShip);
			// insert shippingAddress EOF

			if ($this->db->transStatus() === false) {
				$this->db->transRollback();
				$returnValue = json_encode(array('status' => "failed", "msg" => "Error data"));
			} else {
				$this->db->transCommit();
				$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
			}
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function updateCustomers()
	{
		header('Content-Type: application/json');

		// get model table
		$customersModel = new \App\Models\CustomersModel();
		$customersAddressModel = new \App\Models\CustomersAddressModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"customerId"		=> ["label" => "*CustomerID*", "rules" => "required|min_length[3]|max_length[255]"],
				"customerName"		=> ["label" => "*Customer Name*", "rules" => "required|min_length[3]|max_length[100]"],
				"customerEmail"		=> ["label" => "*Customer Email*", "rules" => "min_length[0]|max_length[100]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$customerId = addslashes($this->request->getPost("customerId"));

			$this->db->transBegin();
			// update customers
			$paramUpdate = array(
				// 'customerId'			=> $customersModel->autoCustomersId('customerId'),
				'customerTypeId'		=> $this->request->getPost("customerTypeId"),
				'customerName'			=> strtoupper($this->request->getPost("customerName")),
				'customerDisplay'		=> strtoupper($this->request->getPost("customerDisplay")),
				'customerEmail'			=> $this->request->getPost("customerEmail"),
				'customerPhone'			=> $this->request->getPost("customerPhone"),
				'customerMobile'		=> $this->request->getPost("customerMobile"),
				'customerCurrency'		=> $this->request->getPost("customerCurrency"),
				'paymentTermId'			=> $this->request->getPost("paymentTermId"),
				'website'				=> $this->request->getPost("customerWebsite"),
				'remark'				=> $this->request->getPost("customerRemark"),
				'statusId'				=> $this->request->getPost("customerStatusId"),
				'updateBy'				=> $this->session->get("userId"),
			);

			$customersModel->update(array('customerId' => $customerId), $paramUpdate);
			// update customer EOF

			// update billingAddress
			$paramAddressBill = array(
				'country'			=> "ID", //$this->request->getPost("addressBillCountry"),
				'address1'			=> $this->request->getPost("addressBillStreet1"),
				'address2'			=> $this->request->getPost("addressBillStreet2"),
				'city'				=> $this->request->getPost("addressBillCity"),
				'state'				=> $this->request->getPost("addressBillState"),
				'zipCode'			=> $this->request->getPost("addressBillZipCode"),
				'phone'				=> $this->request->getPost("addressBillPhone"),
				'fax'				=> $this->request->getPost("addressBillFax"),
				'statusId'			=> 1,
				'updateBy'			=> $this->session->get("userId"),
				'updateDate'		=> date('Y-m-d H:i:s'),
			);
			$customersAddressModel->builder()
				->where(
					array(
						'customerId' => $customerId,
						'customerAddressTypeId' => \CUSTOMER_ADDRESS_TYPE::BILLING_ADDRESS,
						'statusId' => \CUSTOMER_ADDRESS_STATUS::PRIMARY
					)
				)
				->update($paramAddressBill);
			// update billingAddress EOF

			// update shippingAddress
			$paramAddressShip = array(
				'country'			=> "ID", //$this->request->getPost("addressShipCountry"),
				'address1'			=> $this->request->getPost("addressShipStreet1"),
				'address2'			=> $this->request->getPost("addressShipStreet2"),
				'city'				=> $this->request->getPost("addressShipCity"),
				'state'				=> $this->request->getPost("addressShipState"),
				'zipCode'			=> $this->request->getPost("addressShipZipCode"),
				'phone'				=> $this->request->getPost("addressShipPhone"),
				'fax'				=> $this->request->getPost("addressShipFax"),
				'statusId'			=> 1,
				'updateBy'			=> $this->session->get("userId"),
				'updateDate'		=> date('Y-m-d H:i:s'),
			);
			$customersAddressModel->builder()
				->where(
					array(
						'customerId' => $customerId,
						'customerAddressTypeId' => \CUSTOMER_ADDRESS_TYPE::SHIPPING_ADDRESS,
						'statusId' => \CUSTOMER_ADDRESS_STATUS::PRIMARY
					)
				)
				->update($paramAddressShip);
			// update shippingAddress EOF

			if ($this->db->transStatus() === false) {
				$this->db->transRollback();
				$returnValue = json_encode(array('status' => "failed", "msg" => "Error data"));
			} else {
				$this->db->transCommit();
				$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
			}

			// $returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function deleteCustomers()
	{
		header('Content-Type: application/json');

		// get model table
		$customersModel = new \App\Models\CustomersModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$customerId = addslashes($this->request->getPost("customerId"));

			// delete customers
			$delete = $customersModel->delete($customerId);
			if ($delete) {
				$returnValue = json_encode(array('status' => "success", "msg" => "Delete Success"));
			} else {
				foreach ($customersModel->errors() as $error) {
				}
				throw new \Exception($error);
			}
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function formCustomers()
	{
		return view("customers/addCustomers");
	}
}
