<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SalesOrders extends BaseController
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
        return view('salesOrders/salesOrders');
    }
	
	public function getJson()
    {
		// helper
		Helper('web');
		
		// get model table
		$salesOrdersDetailsTempModel = new \App\Models\SalesOrdersDetailsTempModel();

        $page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'salesOrdersDetailsTempId';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'desc';
		$offset = ($page-1) * $rows;
		
		$result = array();
		$result['total'] = $salesOrdersDetailsTempModel->getCount();
		$row = array();
		
		$criteria = $salesOrdersDetailsTempModel->getAll();
		
		foreach($criteria as $data)
		{
			$row[] = array(
				'salesOrderId'		=> $data->salesOrderId,
				'salesOrderNumber'	=> $data->salesOrderNumber,
				'salesOrderDate'	=> date('Y-m-d', strtotime($data->salesOrderDate)),
				'expectedShipmentDate'	=> date('Y-m-d', strtotime($data->expectedShipmentDate)),
				'shipmentDate'		=> Datex($data->shipmentDate),
				'reference'			=> $data->reference,
				'customerId'		=> $data->customerId,
				'customerName'		=> $data->customerName,
				'customerDisplay'	=> $data->customerDisplay,
				'representative'	=> $data->representative,
				'totalAmount'		=> \FormatCurrency($data->totalAmount),
				'paymentTermId'		=> $data->paymentTermId,
				'termName'			=> $data->termName,
				'status'			=> $status,
				'statusId'			=> $data->statusId,
				'inputBy'			=> $data->inputBy,
				'inputDate'			=> date('Y-m-d', strtotime($data->inputDate)),
				'updateBy'			=> $data->updateBy,
				'updateDate'		=> date('Y-m-d', strtotime($data->updateDate))
			);
			
		}
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
    }
	
	/*
	public function updateSalesOrders()
    {
		header('Content-Type: application/json');
		
		// get model table
		$salesOrdersModel = new \App\Models\SalesOrdersModel();
		
		try
		{
			if(empty( $this->request->getPostGet() )) {
				throw new \Exception("Data Empty.");
			}
			
			$this->validation->setRules([
                "userName" 	=> ["label" => "*Name*", "rules" => "required|min_length[3]|max_length[255]"],
                "fullName" 	=> ["label" => "*Full Name*", "rules" => "required|min_length[3]|max_length[255]"],
                "email"		=> ["label" => "*Email*", "rules" => "valid_email|min_length[3]|max_length[255]"],
            ]);
			
			if(!$this->validation->withRequest($this->request)->run()){
				foreach ($this->validation->getErrors() as $error) {}
				throw new \Exception($error);
			}
			
			$userId = addslashes($this->request->getPost("userId"));
			
			//update salesOrders
			$paramUpdate = array(
				'userId'			=> $userId,
				'userName'			=> $this->request->getPost("userName"),
				'fullName'			=> $this->request->getPost("fullName"),
				'email'				=> $this->request->getPost("email"),
				'statusId'			=> $this->request->getPost("statusId"),
				'groupId'			=> $this->request->getPost("groupId"),
				'changePassword'	=> $this->request->getPost("changePassword"),
				'changePassword'	=> $this->request->getPost("changePassword"),
				'updateBy'			=> session()->get("userId"),
			);
			
			// change password
			if(!empty( $this->request->getPost("passwordChange") )) {
				$paramUpdate['password'] = $this->request->getPost("passwordChange");
			}
			
			$salesOrdersModel->where("userId", $userId);
			$salesOrdersModel->set($paramUpdate);
			$salesOrdersModel->update();
			
			$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
		}
		catch(\Exception $ex)
		{
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}
		
		echo $returnValue;
    }
	
	public function createSalesOrders()
    {
		header('Content-Type: application/json');
		
		// get model table
		$salesOrdersModel 			= new \App\Models\SalesOrdersModel();
		$salesOrdersAddressModel 	= new \App\Models\SalesOrdersAddressModel();
		$customersAddressModel 		= new \App\Models\CustomersAddressModel();
		$customersModel 			= new \App\Models\CustomersModel();
		$paymentTermsModel 			= new \App\Models\PaymentTermsModel();
		
		try
		{
			if(empty( $this->request->getPostGet() )) {
				throw new \Exception("Data Empty.");
			}
			
			$this->validation->setRules([
                "salesOrderNumber" 	=> ["label" => "*Sales Order Number*", "rules" => "required|min_length[3]|max_length[255]"],
                "customerId" 	=> ["label" => "*Customer ID*", "rules" => "required|min_length[3]|max_length[255]"],
				"paymentTermId" 	=> ["label" => "*Payment Term*", "rules" => "required|min_length[3]|max_length[255]"],
				"billId" 	=> ["label" => "*Billing Address*", "rules" => "required|min_length[3]|max_length[255]"],
				"shipId" 	=> ["label" => "*Shipping Address*", "rules" => "required|min_length[3]|max_length[255]"],
            ]);
			
			if(!$this->validation->withRequest($this->request)->run()){
				foreach ($this->validation->getErrors() as $error) {}
				throw new \Exception($error);
			}
			
			$getCustomer = $customersModel->where(array('customerId' => $this->request->getPost("customerId"), 'statusId' => 1))->first();
			if($getCustomer == null){
				throw new \Exception("Customer not valid");
			}
			
			$getpaymentTerms = $paymentTermsModel->where(array('paymentTermId' => $this->request->getPost("paymentTermId"), 'statusId' => 1))->first();
			if($paymentTermsModel == null){
				throw new \Exception("Payment Terms not valid");
			}
			
			$this->db->transBegin();
			
				// insert salesOrders
				$paramInsert = array(
					'customerId'			=> $this->request->getPost("customerId"),
					'customerName'			=> $getCustomer->customerName, 
					'customerDisplay'		=> $getCustomer->customerDisplay, 
					'salesOrderNumber'		=> $this->request->getPost("salesOrderNumber"),
					'reference'				=> $this->request->getPost("reference"),
					'salesOrderDate'		=> date('Y-m-d'),
					'expectedShipmentDate'	=> $this->request->getPost("expectedShipmentDate"),
					'paymentTermId'			=> $this->request->getPost("paymentTermId"),
					'termName'				=> $getpaymentTerms->termName,
					// 'representativeId'		=> $this->request->getPost("representativeId"),
					'statusId'				=> \SALES_ORDER_STATUS::DRAFT,
					'inputBy'				=> session()->get("userId"),
				);
				
				$salesOrdersModel->insert($paramInsert);
				// insert salesOrders EOF
				
				// insert billingAddress
				$getCustomerBillAddress = $customersAddressModel->where(array('customerAddressId' => $this->request->getPost("billId")))->first();
				
				if($getCustomerBillAddress != null){
					$paramAddressBill = array(
						'salesOrderId'		=> $salesOrdersModel->getInsertID(),
						'customerId'		=> $this->request->getPost("customerId"),
						'customerAddressTypeId'	=> \CUSTOMER_ADDRESS_TYPE::BILLING_ADDRESS,
						'country'			=> "ID", //$this->request->getPost("addressBillCountry"),
						'address1'			=> $getCustomerBillAddress->address1,
						'address2'			=> $getCustomerBillAddress->address2,
						'city'				=> $getCustomerBillAddress->city,
						'state'				=> $getCustomerBillAddress->state,
						'zipCode'			=> $getCustomerBillAddress->zipCode,
						'phone'				=> $getCustomerBillAddress->phone,
						'fax'				=> $getCustomerBillAddress->fax,
						'statusId'			=> \CUSTOMER_ADDRESS_STATUS::PRIMARY,
						'inputBy'			=> $this->session->get("userId"),
					);
					$salesOrdersAddressModel->insert($paramAddressBill);
				}
				// insert billingAddress EOF
				
				
				// insert shippingAddress
				$getCustomerShipAddress = $customersAddressModel->where(array('customerAddressId' => $this->request->getPost("shipId")))->first();
				if($getCustomerShipAddress != null){
					$paramAddressShip = array(
						'salesOrderId'		=> $salesOrdersModel->getInsertID(),
						'customerId'		=> $this->request->getPost("customerId"),
						'customerAddressTypeId'	=> \CUSTOMER_ADDRESS_TYPE::SHIPPING_ADDRESS,
						'country'			=> "ID", //$this->request->getPost("addressShipCountry"),
						'address1'			=> $getCustomerShipAddress->address1,
						'address2'			=> $getCustomerShipAddress->address2,
						'city'				=> $getCustomerShipAddress->city,
						'state'				=> $getCustomerShipAddress->state,
						'zipCode'			=> $getCustomerShipAddress->zipCode,
						'phone'				=> $getCustomerShipAddress->phone,
						'fax'				=> $getCustomerShipAddress->fax,
						'statusId'			=> \CUSTOMER_ADDRESS_STATUS::PRIMARY,
						'inputBy'			=> $this->session->get("userId"),
					);
					$salesOrdersAddressModel->insert($paramAddressShip);
				}
				// insert shippingAddress EOF
				
				// log_message('error', 'Some variable did not contain a value.');
				
			if ($this->db->transStatus() === false) {
				 $this->db->transRollback();
				 $returnValue = json_encode(array('status' => "failed", "msg" => "Error data"));
			} else {
				$this->db->transCommit();
				$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
			}
			// if($insert) {
				// $returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
			// } else {
					// foreach ($customersModel->errors() as $error) {}
					// throw new \Exception($error);
			// }
			
		}
		catch(\Exception $ex)
		{
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}
		
		echo $returnValue;
    }
	
	public function deleteSalesOrders()
    {
		header('Content-Type: application/json');
		
		// get model table
		$salesOrdersModel = new \App\Models\SalesOrdersModel();
		
		try
		{
			if(empty( $this->request->getPostGet() )) {
				throw new \Exception("Data Empty.");
				// throw new \Exception(($this->request->getJson("salesOrderId")));
			}
			
			$salesOrderId = addslashes($this->request->getPost("salesOrderId"));
			
			// delete salesOrders
			$delete = $salesOrdersModel->delete($salesOrderId);
			if($delete) {
				$returnValue = json_encode(array('status' => "success", "msg" => "Delete Success"));
			} else {
				foreach ($customersModel->errors() as $error) {}
				throw new \Exception($error);
			}
			
		}
		catch(\Exception $ex)
		{
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}
		
		echo $returnValue;
    }
	*/
	
	public function formSalesOrders($action = "")
    {
		// get model table
		$salesOrdersModel = new \App\Models\SalesOrdersModel();
		
		$data = array(
			'action'			=> $action,
			'salesOrderNumber'	=> $salesOrdersModel->autoSalesOrderNumber()
		);
		return view("salesOrders/addSalesOrders", $data);
	}
	
}
