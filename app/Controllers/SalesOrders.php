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

	public function pdfSalesOrders($action = "")
	{
		// helper
		Helper('web');

		if ($action == null) {
			return;
		}

		$salesOrdersModel			= new \App\Models\SalesOrdersModel();
		$salesOrdersDetailsModel	= new \App\Models\SalesOrdersDetailsModel();
		$salesOrdersAmountModel		= new \App\Models\SalesOrdersAmountModel();
		$salesOrdersAddressModel	= new \App\Models\SalesOrdersAddressModel();

		$getSalesOrders = $salesOrdersModel->where(array('salesOrderId' => $action))->first();
		if ($getSalesOrders != null) {
			$data["salesOrders"] = $getSalesOrders;
		}

		$getSalesOrdersAmount = $salesOrdersAmountModel->where(array('salesOrderId' => $action))->findAll();
		if ($getSalesOrders != null) {
			$data["salesOrdersAmount"] = $getSalesOrdersAmount;
		}

		$data["salesOrdersDetails"] = $salesOrdersDetailsModel->where(array('salesOrderId' => $action, 'statusId' => 1))->orderBy('sort', 'asc')->findAll();

		// Address Customer
		$getCustomerBillAddress		= $salesOrdersAddressModel->where(array('salesOrderId' => $action, 'statusId' => 1, 'customerAddressTypeId'	=> \CUSTOMER_ADDRESS_TYPE::BILLING_ADDRESS))->first();
		$getCustomerShipAddress		= $salesOrdersAddressModel->where(array('salesOrderId' => $action, 'statusId' => 1, 'customerAddressTypeId'	=> \CUSTOMER_ADDRESS_TYPE::SHIPPING_ADDRESS))->first();

		$data['bill'] = json_decode(json_encode(array(
			'country'		=> $getCustomerBillAddress->country,
			'address1'		=> $getCustomerBillAddress->address1,
			'address2'	=> $getCustomerBillAddress->address2,
			'city'			=> $getCustomerBillAddress->city,
			'state'			=> $getCustomerBillAddress->state,
			'zipCode'		=> $getCustomerBillAddress->zipCode,
			'phone'			=> $getCustomerBillAddress->phone,
			'fax'			=> $getCustomerBillAddress->fax,

			// 'shipCountry'			=> $getCustomerShipAddress->country,
			// 'shipAddress1'			=> $getCustomerShipAddress->address1,
			// 'shipAddress2'			=> $getCustomerShipAddress->address2,
			// 'shipCity'				=> $getCustomerShipAddress->city,
			// 'shipState'				=> $getCustomerShipAddress->state,
			// 'shipZipCode'			=> $getCustomerShipAddress->zipCode,
			// 'shipPhone'				=> $getCustomerShipAddress->phone,
			// 'shipFax'				=> $getCustomerShipAddress->fax
		)), false);

		// echo var_dump($data); exit;
		return view('salesOrders/pdfSalesOrders', $data);
	}

	public function getJson()
	{
		// helper
		Helper('web');

		// get model table
		$salesOrdersModel = new \App\Models\SalesOrdersModel();

		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'salesOrderId';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'desc';
		$offset = ($page - 1) * $rows;

		$result = array();
		$result['total'] = $salesOrdersModel->getCount();
		$row = array();

		$criteria = $salesOrdersModel->getAll(array("sort" => $sort, "order" => $order, "offset" => $offset, "rows" => $rows));

		foreach ($criteria as $data) {
			if ($data->statusId == \SALES_ORDER_STATUS::DRAFT) {
				$status = "<img src='" . base_url('assets/css/icons/st_grey.gif') . "'> Draft";
			}
			// else if ( $data->statusId == \SALES_ORDER_STATUS::APPROVAL ) {
			// $status = "<img src='" . base_url('assets/css/icons/st_blue.gif') . "'> Approval";
			// }
			else if ($data->statusId == \SALES_ORDER_STATUS::CONFIRM) {
				$status = "<div class='circle green'></div> Confirm";
			} else if ($data->statusId == \SALES_ORDER_STATUS::PROGRESS) {
				$status = "<div class='circle green'></div> Progress";
			} else if ($data->statusId == \SALES_ORDER_STATUS::SHIPMENT) {
				$status = "<div class='circle green'></div> Shipment";
			} else if ($data->statusId == \SALES_ORDER_STATUS::CLOSED) {
				$status = "<div class='circle purple'></div> Closed";
			}

			$row[] = array(
				'billAddress1'		=> $data->billAddress1,
				'salesOrderId'		=> $data->salesOrderId,
				'salesOrderNumber'	=> $data->salesOrderNumber,
				'salesOrderDate'	=> date('Y-m-d', strtotime($data->salesOrderDate)),
				'expectedShipmentDate'	=> date('Y-m-d', strtotime($data->expectedShipmentDate)),
				'shipmentDate'		=> Datex($data->shipmentDate),
				'reference'			=> $data->reference,
				'customerId'		=> $data->customerId,
				'customerName'		=> $data->customerName,
				'customerDisplay'	=> $data->customerDisplay,
				'representativeId'	=> $data->representativeId,
				'representative'	=> $data->representative,
				'totalAmount'		=> \FormatCurrency($data->totalAmount),
				'paymentTermId'		=> $data->paymentTermId,
				'termName'			=> $data->termName,
				'status'			=> $status,
				'statusId'			=> $data->statusId,
				'inputUserName'		=> $data->userName,
				'inputBy'			=> $data->inputBy,
				'inputDate'			=> date('Y-m-d', strtotime($data->inputDate)),
				'updateBy'			=> $data->updateBy,
				'updateDate'		=> date('Y-m-d', strtotime($data->updateDate))
			);
		}
		$result = array_merge($result, array('rows' => $row));
		return json_encode($result);
	}

	public function getJsonDetailsTemp()
	{
		// helper
		Helper('web');

		// get model table
		$salesOrdersModel		= new \App\Models\SalesOrdersModel();
		$SalesOrdersDetailsTemp = new \App\Models\SalesOrdersDetailsTempModel();

		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'inputDate';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'asc';
		$offset = ($page - 1) * $rows;

		$result = array();
		$result['total'] = $SalesOrdersDetailsTemp->getCount();
		$row = array();
		$subTotal = 0;

		$criteria = $SalesOrdersDetailsTemp->getAll();

		foreach ($criteria as $data) {
			if ($data->statusId == \USERS::ACTIVE) {
				$status = "<div class='circle green'></div> Active";
			} else if ($data->statusId == \USERS::DISABLED) {
				$status = "<div class='circle red'></div> Disable";
			}

			$row[] = array(
				'salesOrderNumber'		=> $salesOrdersModel->autoSalesOrderNumber(),
				'salesOrderDetailId'	=> $data->salesOrderDetailId,
				'productId'				=> $data->productId,
				'productNumber'			=> $data->productNumber,
				'productName'			=> $data->productName,
				'priceSell'				=> $data->priceSell,
				'quantity'				=> $data->quantity,
				'amount'				=> \FormatCurrency($data->amount),
				'unit'					=> $data->unit,
			);

			$subTotal += $data->amount;
		}

		$result = array_merge($result, array('rows' => $row, 'subTotal' => $subTotal));
		return json_encode($result);
	}

	public function getJsonDetails()
	{
		// helper
		Helper('web');

		// get model table
		$salesOrdersDetailsModel = new \App\Models\SalesOrdersDetailsModel();

		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'sort';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'asc';
		$offset = ($page - 1) * $rows;

		$result = array();
		$result['total'] = $salesOrdersDetailsModel->getCount();
		$row = array();
		$subTotal = 0;

		$criteria = $salesOrdersDetailsModel->getAll(array("sort" => $sort, "order" => $order, "offset" => $offset, "rows" => $rows));

		foreach ($criteria as $data) {
			if ($data->statusId == \USERS::ACTIVE) {
				$status = "<div class='circle green'></div> Active";
			} else if ($data->statusId == \USERS::DISABLED) {
				$status = "<div class='circle red'></div> Disable";
			}

			$row[] = array(
				'salesOrderDetailId'	=> $data->salesOrderDetailId,
				'salesOrderNumber'		=> $data->salesOrderNumber,
				'productId'				=> $data->productId,
				'productNumber'			=> $data->productNumber,
				'productName'			=> $data->productName,
				'priceSell'				=> $data->priceSell,
				'quantity'				=> $data->quantity,
				'delivery'				=> $salesOrdersDetailsModel->getDelivered($data->salesOrderDetailId, $data->productId),
				'totalAmount'			=> $data->amount,
				'amount'				=> \FormatCurrency($data->amount),
				'unit'					=> $data->unit,
			);

			$subTotal += $data->amount;
		}

		$result = array_merge($result, array('rows' => $row, 'subTotal' => $subTotal));
		return json_encode($result);
	}

	public function updateSalesOrders()
	{
		// get model table
		$salesOrdersModel 				= new \App\Models\SalesOrdersModel();
		$salesOrdersDetailsModel		= new \App\Models\SalesOrdersDetailsModel();
		$salesOrdersAddressModel 		= new \App\Models\SalesOrdersAddressModel();
		$salesOrdersAmountModel			= new \App\Models\SalesOrdersAmountModel();
		$customersAddressModel 			= new \App\Models\CustomersAddressModel();
		$customersModel 				= new \App\Models\CustomersModel();
		$paymentTermsModel 				= new \App\Models\PaymentTermsModel();
		$productsModel					= new \App\Models\ProductsModel();
		$salesOrdersAmount				= 0;
		try {
			if (empty($this->request->getPost())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"salesOrdersDetails"	=> ["label" => "*Sales Order Details*", "rules" => "required|min_length[100]", "errors" => ["min_length" => "Product Not Found"]],
				"salesOrderId"			=> ["label" => "*Sales Order ID*", "rules" => "required|min_length[3]|max_length[255]"],
				"salesOrderNumber"		=> ["label" => "*Sales Order Number*", "rules" => "required|min_length[3]|max_length[255]"],
				"customerId"			=> ["label" => "*Customer ID*", "rules" => "required|min_length[3]|max_length[255]"],
				"paymentTermId"			=> ["label" => "*Payment Term*", "rules" => "required|min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$getSalesOrders = $salesOrdersModel->where(array('salesOrderId' => $this->request->getPost("salesOrderId")))->first();
			if ($getSalesOrders == null) {
				throw new \Exception("Sales Orders ID not valid");
			}

			if ($getSalesOrders->statusId != \SALES_ORDER_STATUS::DRAFT) {
				throw new \Exception("sales orders status not is draft");
			}

			$getCustomer = $customersModel->where(array('customerId' => $this->request->getPost("customerId"), 'statusId' => 1))->first();
			if ($getCustomer == null) {
				throw new \Exception("Customer not valid");
			}

			$getpaymentTerms = $paymentTermsModel->where(array('paymentTermId' => $this->request->getPost("paymentTermId"), 'statusId' => 1))->first();
			if ($paymentTermsModel == null) {
				throw new \Exception("Payment Terms not valid");
			}

			$this->db->transBegin();

			// update salesOrders
			$paramSalesOrders = array(
				'customerId'			=> $this->request->getPost("customerId"),
				'customerName'			=> $getCustomer->customerName,
				'customerDisplay'		=> $getCustomer->customerDisplay,
				'salesOrderNumber'		=> $this->request->getPost("salesOrderNumber"),
				'reference'				=> $this->request->getPost("reference"),
				'salesOrderDate'		=> date('Y-m-d'),
				'expectedShipmentDate'	=> $this->request->getPost("expectedShipmentDate"),
				'representativeId'		=> $this->request->getPost("representativeId"),
				'paymentTermId'			=> $this->request->getPost("paymentTermId"),
				'termName'				=> $getpaymentTerms->termName,
				'inputBy'				=> session()->get("userId"),
			);

			$salesOrdersModel->where("salesOrderId", $this->request->getPost("salesOrderId"));
			$salesOrdersModel->set($paramSalesOrders);
			$salesOrdersModel->update();
			// update salesOrders EOF

			// update billingAddress

			// $getCustomerBillAddress = $salesOrdersAddressModel->where($whereBillAddress)->first();

			if ($this->request->getPost("billId") != null) {
				$getCustomerBillAddress = $customersAddressModel->where(array('customerAddressId' => $this->request->getPost("billId")))->first();

				if ($getCustomerBillAddress != null) {
					$paramAddressBill = array(
						// 'salesOrderId'		=> $salesOrdersModel->getInsertID(),
						'customerId'		=> $this->request->getPost("customerId"),
						// 'customerAddressTypeId'	=> \CUSTOMER_ADDRESS_TYPE::BILLING_ADDRESS,
						'country'			=> "ID", //$this->request->getPost("addressBillCountry"),
						'address1'			=> $getCustomerBillAddress->address1,
						'address2'			=> $getCustomerBillAddress->address2,
						'city'				=> $getCustomerBillAddress->city,
						'state'				=> $getCustomerBillAddress->state,
						'zipCode'			=> $getCustomerBillAddress->zipCode,
						'phone'				=> $getCustomerBillAddress->phone,
						'fax'				=> $getCustomerBillAddress->fax,
						// 'statusId'			=> \CUSTOMER_ADDRESS_STATUS::PRIMARY,
						'inputBy'			=> $this->session->get("userId"),
					);
					$whereBillAddress = array('salesOrderId' => $getSalesOrders->salesOrderId, 'customerAddressTypeId' => \CUSTOMER_ADDRESS_TYPE::BILLING_ADDRESS);
					$salesOrdersAddressModel->where($whereBillAddress);
					$salesOrdersAddressModel->set($paramAddressBill);
					$salesOrdersAddressModel->update();
				}
			}
			// update billingAddress EOF

			// update shippingAddress
			// $getCustomerShipAddress = $salesOrdersAddressModel->where($whereShipAddress)->first();

			if ($this->request->getPost("shipId") != null) {

				$getCustomerShipAddress = $customersAddressModel->where(array('customerAddressId' => $this->request->getPost("shipId")))->first();
				if ($getCustomerShipAddress != null) {
					$paramAddressShip = array(
						// 'salesOrderId'		=> $salesOrdersModel->getInsertID(),
						'customerId'		=> $this->request->getPost("customerId"),
						// 'customerAddressTypeId'	=> \CUSTOMER_ADDRESS_TYPE::SHIPPING_ADDRESS,
						'country'			=> "ID", //$this->request->getPost("addressShipCountry"),
						'address1'			=> $getCustomerShipAddress->address1,
						'address2'			=> $getCustomerShipAddress->address2,
						'city'				=> $getCustomerShipAddress->city,
						'state'				=> $getCustomerShipAddress->state,
						'zipCode'			=> $getCustomerShipAddress->zipCode,
						'phone'				=> $getCustomerShipAddress->phone,
						'fax'				=> $getCustomerShipAddress->fax,
						// 'statusId'			=> \CUSTOMER_ADDRESS_STATUS::PRIMARY,
						'inputBy'			=> $this->session->get("userId"),
					);
					$whereShipAddress = array('salesOrderId' => $getSalesOrders->salesOrderId, 'customerAddressTypeId' => \CUSTOMER_ADDRESS_TYPE::SHIPPING_ADDRESS);
					$salesOrdersAddressModel->where($whereShipAddress);
					$salesOrdersAddressModel->set($paramAddressShip);
					$salesOrdersAddressModel->update();
				}
			}
			// update shippingAddress EOF

			// rubah semua status sales_orders_details menjadi 0
			$salesOrdersDetailsModel->deleteBySalesOrderId($this->request->getPost("salesOrderId"));
			// Parse Json
			$salesOrdersDetails = json_decode($this->request->getPost('salesOrdersDetails'));
			foreach ($salesOrdersDetails as $key => $dataDetails) {
				$getProduct = $productsModel->where(array('productId' => $dataDetails->productId, 'statusId' => 1))->first();
				if ($getProduct == null) {
					throw new \Exception("Product not valid");
				}

				if ($dataDetails->quantity <= 0) {
					throw new \Exception("Quantity 0 not valid");
				}

				$amount = $dataDetails->quantity * $dataDetails->priceSell;
				$paramSalesOrdersDetail = array(
					'productId'			=> $dataDetails->productId,
					'productNumber'		=> $dataDetails->productNumber,
					'productName'		=> $dataDetails->productName,
					'productType'		=> $dataDetails->productType,
					'priceCost'			=> $dataDetails->priceCost,
					'priceSell'			=> $dataDetails->priceSell,
					'quantity'			=> $dataDetails->quantity,
					'amount'			=> $amount,
					'length'			=> $getProduct->length,
					'width'				=> $getProduct->width,
					'height'			=> $getProduct->height,
					'weight'			=> $getProduct->weight,
					'unit'				=> $getProduct->unit,
					'statusId'			=> \PRODUCTS::ACTIVE,
					'sort'				=> $key,
					'inputBy'			=> session()->get("userId"),
				);

				if ($dataDetails->salesOrderDetailId != null) {
					// update table `sales_orders_details`
					$salesOrdersDetailsModel->where("salesOrderDetailId", $dataDetails->salesOrderDetailId);
					$salesOrdersDetailsModel->set($paramSalesOrdersDetail);
					$salesOrdersDetailsModel->update();
				} else {
					// insert table `sales_orders_details`
					$paramSalesOrdersDetail["salesOrderId"] = $this->request->getPost("salesOrderId");
					$salesOrdersDetailsModel->insert($paramSalesOrdersDetail);
				}

				$salesOrdersAmount += $amount;
			}

			// SubTotal
			$salesOrdersAmountModel->UpdateOrInsert(
				$this->request->getPost("salesOrderId"),
				\SALES_ORDER_AMOUNT::SUBTOTAL,
				\SALES_ORDER_AMOUNT_TITLE::SUBTOTAL,
				$salesOrdersAmount
			);

			// Discon
			$salesOrdersAmountModel->UpdateOrInsert(
				$this->request->getPost("salesOrderId"),
				\SALES_ORDER_AMOUNT::DISCON,
				\SALES_ORDER_AMOUNT_TITLE::DISCON,
				(int)$this->request->getPost("discon")
			);

			// Shipping Charge
			$salesOrdersAmountModel->UpdateOrInsert(
				$this->request->getPost("salesOrderId"),
				\SALES_ORDER_AMOUNT::SHIPPCHARGE,
				\SALES_ORDER_AMOUNT_TITLE::SHIPPCHARGE,
				(int)$this->request->getPost("shippCharge")
			);

			// calc totalAmount sales orders
			$salesOrdersAmount += (int)$this->request->getPost("discon");
			$salesOrdersAmount += (int)$this->request->getPost("shippCharge");

			// update amount di table `sales_orders`
			$salesOrdersModel->where("salesOrderId", $this->request->getPost("salesOrderId"));
			$salesOrdersModel->set(array("totalAmount" => $salesOrdersAmount));
			$salesOrdersModel->update();


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

	public function createSalesOrders()
	{
		header('Content-Type: application/json');

		// get model table
		$salesOrdersModel 				= new \App\Models\SalesOrdersModel();
		$salesOrdersDetailsModel		= new \App\Models\SalesOrdersDetailsModel();
		$salesOrdersAddressModel 		= new \App\Models\SalesOrdersAddressModel();
		$salesOrdersAmountModel			= new \App\Models\SalesOrdersAmountModel();
		$customersAddressModel 			= new \App\Models\CustomersAddressModel();
		$customersModel 				= new \App\Models\CustomersModel();
		$paymentTermsModel 				= new \App\Models\PaymentTermsModel();
		$productsModel					= new \App\Models\ProductsModel();
		$salesOrdersAmount				= 0;

		try {
			if (empty($this->request->getPost())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"salesOrdersDetails" => ["label" => "*Sales Order Details*", "rules" => "required|min_length[100]", "errors" => ["min_length" => "Product Not Found"]],
				"salesOrderNumber" 	=> ["label" => "*Sales Order Number*", "rules" => "required|is_unique[sales_orders.salesOrderNumber]|min_length[3]|max_length[255]"],
				"customerId"		=> ["label" => "*Customer ID*", "rules" => "required|min_length[3]|max_length[255]"],
				"paymentTermId"		=> ["label" => "*Payment Term*", "rules" => "required|min_length[3]|max_length[255]"],
				"billId"			=> ["label" => "*Billing Address*", "rules" => "required|min_length[3]|max_length[255]"],
				"shipId"			=> ["label" => "*Shipping Address*", "rules" => "required|min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$getCustomer = $customersModel->where(array('customerId' => $this->request->getPost("customerId"), 'statusId' => 1))->first();
			if ($getCustomer == null) {
				throw new \Exception("Customer not valid");
			}

			$getpaymentTerms = $paymentTermsModel->where(array('paymentTermId' => $this->request->getPost("paymentTermId"), 'statusId' => 1))->first();
			if ($paymentTermsModel == null) {
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
				'representativeId'		=> $this->request->getPost("representativeId"),
				'statusId'				=> \SALES_ORDER_STATUS::DRAFT,
				'inputBy'				=> session()->get("userId"),
			);

			$salesOrdersModel->insert($paramInsert);
			// insert salesOrders EOF

			// insert billingAddress
			$getCustomerBillAddress = $customersAddressModel->where(array('customerAddressId' => $this->request->getPost("billId")))->first();

			if ($getCustomerBillAddress != null) {
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
			if ($getCustomerShipAddress != null) {
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

			// Parse Json
			log_message("error", $this->request->getPost('salesOrdersDetails'));
			$salesOrdersDetails = json_decode($this->request->getPost('salesOrdersDetails'));

			foreach ($salesOrdersDetails as $key => $dataDetails) {
				log_message("error", $this->request->getPost('salesOrdersDetails'));
				$getProduct = $productsModel->where(array('productId' => $dataDetails->productId, 'statusId' => 1))->first();
				if ($getProduct == null) {
					throw new \Exception("Product not valid");
				}

				if ($dataDetails->quantity <= 0) {
					throw new \Exception("Quantity 0 not valid");
				}

				$amount = $dataDetails->quantity * $dataDetails->priceSell;
				$paramSalesOrdersDetail = array(
					'productId'			=> $dataDetails->productId,
					'productNumber'		=> $dataDetails->productNumber,
					'productName'		=> $dataDetails->productName,
					'productType'		=> $dataDetails->productType,
					'priceCost'			=> $dataDetails->priceCost,
					'priceSell'			=> $dataDetails->priceSell,
					'quantity'			=> $dataDetails->quantity,
					'amount'			=> $amount,
					'length'			=> $getProduct->length,
					'width'				=> $getProduct->width,
					'height'			=> $getProduct->height,
					'weight'			=> $getProduct->weight,
					'unit'				=> $getProduct->unit,
					'statusId'			=> \PRODUCTS::ACTIVE,
					'sort'				=> $key,
					'inputBy'			=> session()->get("userId"),
				);

				if ($dataDetails->salesOrderDetailId != null) {
					// update table `sales_orders_details`
					$salesOrdersDetailsModel->where("salesOrderDetailId", $dataDetails->salesOrderDetailId);
					$salesOrdersDetailsModel->set($paramSalesOrdersDetail);
					$salesOrdersDetailsModel->update();
				} else {
					// insert table `sales_orders_details`
					$paramSalesOrdersDetail["salesOrderId"] = $salesOrdersModel->getInsertID();
					$salesOrdersDetailsModel->insert($paramSalesOrdersDetail);
				}

				$salesOrdersAmount += $amount;
			}

			// SubTotal
			$salesOrdersAmountModel->UpdateOrInsert(
				$salesOrdersModel->getInsertID(),
				\SALES_ORDER_AMOUNT::SUBTOTAL,
				\SALES_ORDER_AMOUNT_TITLE::SUBTOTAL,
				$salesOrdersAmount
			);

			// Discon
			$salesOrdersAmountModel->UpdateOrInsert(
				$salesOrdersModel->getInsertID(),
				\SALES_ORDER_AMOUNT::DISCON,
				\SALES_ORDER_AMOUNT_TITLE::DISCON,
				(int)$this->request->getPost("discon")
			);

			// Shipping Charge
			$salesOrdersAmountModel->UpdateOrInsert(
				$salesOrdersModel->getInsertID(),
				\SALES_ORDER_AMOUNT::SHIPPCHARGE,
				\SALES_ORDER_AMOUNT_TITLE::SHIPPCHARGE,
				(int)$this->request->getPost("shippCharge")
			);

			// calc totalAmount sales orders
			$salesOrdersAmount += (int)$this->request->getPost("discon");
			$salesOrdersAmount += (int)$this->request->getPost("shippCharge");

			// update amount di table `sales_orders`
			$salesOrdersModel->where("salesOrderId", $salesOrdersModel->getInsertID());
			$salesOrdersModel->set(array("totalAmount" => $salesOrdersAmount));
			$salesOrdersModel->update();

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

	public function deleteSalesOrders()
	{
		header('Content-Type: application/json');

		// get model table
		$salesOrdersModel = new \App\Models\SalesOrdersModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$salesOrderId = addslashes($this->request->getPost("salesOrderId"));

			// delete salesOrders
			$delete = $salesOrdersModel->delete($salesOrderId);
			if ($delete) {
				$returnValue = json_encode(array('status' => "success", "msg" => "Delete Success"));
			} else {
				foreach ($salesOrdersModel->errors() as $error) {
				}
				throw new \Exception($error);
			}
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function viewSalesOrders($action = "")
	{
		// get model
		$salesOrdersModel 	= new \App\Models\SalesOrdersModel();
		$approvalsModel 		= new \App\Models\ApprovalsModel();

		$getSalesOrders 	= $salesOrdersModel->where(array('salesOrderId' => $action))->first();
		$getApproval		= $approvalsModel->where(array('option' => \APPROVAL::SALES_ORDERS, 'optionId' => $action, 'statusId' => 0))->orderBy('sort', 'asc')->first();

		if ($getSalesOrders->statusId > \SALES_ORDER_STATUS::DRAFT) {
			$approvalButton = "style='display:none'";
		} else if ($getApproval == null) {
			// tidak perlu approval, langsung confirm
			$approvalLabel = "Confirm";
			// $approvalButton = "style='display:none'";
		} else {
			// perlu approval
			$approvalLabel = $getApproval->optionName;
			$approvalButton = (strpos($getApproval->userId, session()->get('userId')) != true) ? 'disabled' : '';
		}

		$data = array(
			'approvalId'		=> $getApproval->id,
			'approvalHeader'	=> hash('sha256', $getApproval->id . $action . APIKEY),
			'approvalLabel'		=> $approvalLabel,
			'approvalButton'	=> $approvalButton,

			'action'			=> $action,
			'salesOrderNumber'	=> $getSalesOrders->salesOrderNumber,
		);
		return view("salesOrders/viewSalesOrders", $data);
	}

	public function approvalSalesOrders()
	{
		// get model
		$salesOrdersModel 	= new \App\Models\SalesOrdersModel();
		$approvalsModel		= new \App\Models\ApprovalsModel();

		try {
			if (empty($this->request->getPost())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"salesOrderId"		=> ["label" => "*Sales Order ID*", "rules" => "required|min_length[3]|max_length[10]"],
				"approvalHeader"	=> ["label" => "*approvalHeader*", "rules" => "required|min_length[1]|max_length[100]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			// kasih signature biar keren
			$sign = hash('sha256', $this->request->getPost("approvalId") . $this->request->getPost("salesOrderId") . APIKEY);
			if ($sign != $this->request->getPost("approvalHeader")) {
				throw new \Exception("Error");
			}

			$getSalesOrder	= $salesOrdersModel->where(array('salesOrderId' => $this->request->getPost("salesOrderId"), 'statusId' => \SALES_ORDER_STATUS::DRAFT))->first();
			if ($getSalesOrder == null) {
				throw new \Exception("sales orders status not is draft");
			}

			$getApproval	= $approvalsModel->where(array('id' => $this->request->getPost("approvalId"), 'statusId' => 0))->orderBy('sort', 'asc')->first();

			if ($getApproval == null) {

				// tidak perlu approval, langsung confirm
				//update salesOrders
				// $paramUpdate = array(
				// 'statusId'	=> \SALES_ORDER_STATUS::CONFIRM
				// );

				// $salesOrdersModel->where("salesOrderId", $this->request->getPost("salesOrderId"));
				// $salesOrdersModel->set($paramUpdate);
				// $salesOrdersModel->update();
				$salesOrdersModel->changeStatus($this->request->getPost("salesOrderId"), \SALES_ORDER_STATUS::CONFIRM);
			} else {
				// perlu approval
				if (empty($this->request->getPost("approvalId"))) {
					throw new \Exception("approvalId is empty");
				}

				if (strpos($getApproval->userId, session()->get('userId')) != true) {
					throw new \Exception('Error Permission');
				}

				//update approvals
				$paramUpdate = array(
					'statusId'	=> \APPROVAL_STATUS::APPROVED,
					'updateBy'	=> session()->get('userId'),
				);

				$approvalsModel->where("id", $this->request->getPost("approvalId"));
				$approvalsModel->set($paramUpdate);
				$returnUpdate = $approvalsModel->update();
				if (!$returnUpdate) {
					foreach ($approvalsModel->errors() as $error) {
					}
					throw new \Exception($error);
				}
			}

			$returnValue = json_encode(array('status' => "success", "msg" => "Status Success"));
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function formSalesOrders($action = "")
	{
		// get model table
		$salesOrdersModel		= new \App\Models\SalesOrdersModel();
		$salesOrdersAmountModel	= new \App\Models\SalesOrdersAmountModel();

		if ($action == "create") {
			$salesOrdersDetailsTempModel	= new \App\Models\SalesOrdersDetailsTempModel();
			$salesOrdersDetailsTempModel->where('inputBy', session()->get('userId'))->delete();

			$data['urlDatagrid'] = base_url('salesorders/getJsonDetailsTemp');
		} else {
			$getSalesOrder	= $salesOrdersModel->where(array('salesOrderId' => $action, 'statusId' => \SALES_ORDER_STATUS::DRAFT))->first();
			if ($getSalesOrder == null) {
				return ("sales orders status not is draft");
			}

			// for update salesOrders
			$salesOrdersAddressModel 		= new \App\Models\SalesOrdersAddressModel();
			$getCustomerBillAddress		= $salesOrdersAddressModel->where(array('salesOrderId' => $action, 'statusId' => 1, 'customerAddressTypeId'	=> \CUSTOMER_ADDRESS_TYPE::BILLING_ADDRESS))->first();
			$getCustomerShipAddress		= $salesOrdersAddressModel->where(array('salesOrderId' => $action, 'statusId' => 1, 'customerAddressTypeId'	=> \CUSTOMER_ADDRESS_TYPE::SHIPPING_ADDRESS))->first();

			$data = array(
				'billCountry'			=> $getCustomerBillAddress->country,
				'billAddress1'			=> $getCustomerBillAddress->address1,
				'billAddress2'			=> $getCustomerBillAddress->address2,
				'billCity'				=> $getCustomerBillAddress->city,
				'billState'				=> $getCustomerBillAddress->state,
				'billZipCode'			=> $getCustomerBillAddress->zipCode,
				'billPhone'				=> $getCustomerBillAddress->phone,
				'billFax'				=> $getCustomerBillAddress->fax,

				'shipCountry'			=> $getCustomerShipAddress->country,
				'shipAddress1'			=> $getCustomerShipAddress->address1,
				'shipAddress2'			=> $getCustomerShipAddress->address2,
				'shipCity'				=> $getCustomerShipAddress->city,
				'shipState'				=> $getCustomerShipAddress->state,
				'shipZipCode'			=> $getCustomerShipAddress->zipCode,
				'shipPhone'				=> $getCustomerShipAddress->phone,
				'shipFax'				=> $getCustomerShipAddress->fax
			);
			$data['urlDatagrid'] = base_url('salesorders/getJsonDetails?salesOrderId=' . $action);
		}

		$salesOrdersAmount	= array();
		$salesAmount		= $salesOrdersAmountModel->where(array('salesOrderId' => $action, 'statusId' => 1))->findAll();
		foreach ($salesAmount as $amountDetail) {
			$salesOrdersAmount[$amountDetail->name] = $amountDetail->value;
		}
		// echo var_dump($salesOrdersAmount["sub_total"]);
		// exit;
		$data['salesAmount']		= $salesOrdersAmount;
		$data['action']				= $action;
		$data['salesOrderNumber']	= $salesOrdersModel->autoSalesOrderNumber();

		return view("salesOrders/addSalesOrders", $data);
	}

	// details
	public function formSalesOrdersDetails($action = "")
	{
		$data['urlProductId'] = base_url('combogrid/combogridProductsSalesOrdersDetails/' . $action);
		return view("salesOrders/addSalesOrdersDetails", $data);
	}

	public function createSalesOrdersDetails($action = "")
	{
		header('Content-Type: application/json');

		// helper
		Helper('web');

		// get model table
		$salesOrdersModel				= new \App\Models\SalesOrdersModel();
		$salesOrdersDetailsModel		= new \App\Models\SalesOrdersDetailsModel();
		$salesOrdersDetailsTempModel	= new \App\Models\SalesOrdersDetailsTempModel();
		$productsModel					= new \App\Models\ProductsModel();

		try {
			if (empty($this->request->getPost())) {
				throw new \Exception("Data Empty.");
			}

			if (empty($action)) {
				throw new \Exception("Action Empty.");
			}

			$getSalesOrder	= $salesOrdersModel->where(array('salesOrderId' => $action, 'statusId' => \SALES_ORDER_STATUS::DRAFT))->first();
			if ($getSalesOrder == null and $action != "create") {
				throw new \Exception("sales orders status not is draft");
			}

			$this->validation->setRules([
				"productId"	=> ["label" => "*productId*", "rules" => "required|min_length[1]|max_length[10]"],
				"quantity"	=> ["label" => "*Quantity*", "rules" => "required|min_length[1]|max_length[10]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$getProduct = $productsModel->where(array('productId' => $this->request->getPost("productId"), 'statusId' => 1))->first();
			if ($getProduct == null) {
				throw new \Exception("Product not valid");
			}

			if ($this->request->getPost("quantity") <= 0) {
				throw new \Exception("Quantity 0 not valid");
			}

			$this->db->transBegin();

			// insert SalesOrdersDetailsTempModel
			$amount = ($this->request->getPost("quantity") * $getProduct->priceSell);
			$paramInsert = array(
				'productId'			=> $getProduct->productId,
				'productNumber'		=> $getProduct->productNumber,
				'productName'		=> $getProduct->productName,
				'productType'		=> $getProduct->productType,
				'priceCost'			=> $getProduct->priceCost,
				'priceSell'			=> $getProduct->priceSell,
				'quantity'			=> $this->request->getPost("quantity"),
				'amount'			=> \FormatCurrency($amount),
				'totalAmount'		=> $amount,
				'unit'				=> $getProduct->unit,
				// 'length'			=> $getProduct->length,
				// 'width'				=> $getProduct->width,
				// 'height'			=> $getProduct->height,
				// 'weight'			=> $getProduct->weight,
				// 'statusId'			=> \PRODUCTS::ACTIVE,
				// 'inputBy'			=> session()->get("userId"),
			);
			/*
				if ( $action == "create" ) {
					
					// insert table `salesOrdersDetailsTemp`
					$salesOrdersDetailsTempModel->insert($paramInsert);
					
				} else {
					
					// insert table `salesOrdersDetails`
					$paramInsert["salesOrderId"] = $action;
					$salesOrdersDetailsModel->insert($paramInsert);
					
				}
				*/
			// insert SalesOrdersDetailsTempModel EOF

			if ($this->db->transStatus() === false) {
				$this->db->transRollback();
				$returnValue = json_encode(array('status' => "failed", "msg" => "Error data"));
			} else {
				$this->db->transCommit();
				$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success", "data" => $paramInsert));
			}
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function deleteSalesOrdersDetails($action = "")
	{
		header('Content-Type: application/json');

		// get model table
		$salesOrdersModel				= new \App\Models\SalesOrdersModel();
		$salesOrdersDetailsModel		= new \App\Models\SalesOrdersDetailsModel();
		$salesOrdersDetailsTempModel	= new \App\Models\SalesOrdersDetailsTempModel();

		try {
			if (empty($this->request->getPost())) {
				throw new \Exception("Data Empty.");
				// throw new \Exception(($this->request->getJson("salesOrderDetailId")));
			}

			if (empty($action)) {
				throw new \Exception("Action Empty.");
			}

			$getSalesOrder	= $salesOrdersModel->where(array('salesOrderId' => $action, 'statusId' => \SALES_ORDER_STATUS::DRAFT))->first();
			if ($getSalesOrder == null and $action != "create") {
				throw new \Exception("sales orders status not is draft");
			}

			$salesOrderDetailId = addslashes($this->request->getPost("salesOrderDetailId"));

			if ($action == "create") {

				// delete table `salesOrdersDetailsTemp`
				$deleteTemp = $salesOrdersDetailsTempModel->delete($salesOrderDetailId);
				if ($deleteTemp) {
					$returnValue = json_encode(array('status' => "success", "msg" => "Delete Success"));
				} else {
					foreach ($salesOrdersDetailsTempModel->errors() as $error) {
					}
					throw new \Exception($error);
				}
			} else {

				// delete table `salesOrdersDetails`
				// $delete = $salesOrdersDetailsModel->delete($salesOrderDetailId);
				// if($delete) {
				$returnValue = json_encode(array('status' => "success", "msg" => "Delete Success"));
				// } else {
				// foreach ($salesOrdersDetailsModel->errors() as $error) {}
				// throw new \Exception($error);
				// }

			}
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function updateSalesOrdersDetails($action = "")
	{
		header('Content-Type: application/json');

		// helper
		Helper('web');

		// get model table
		$salesOrdersModel				= new \App\Models\SalesOrdersModel();
		$salesOrdersDetailsModel 		= new \App\Models\SalesOrdersDetailsModel();
		$salesOrdersDetailsTempModel	= new \App\Models\SalesOrdersDetailsTempModel();
		$productsModel					= new \App\Models\ProductsModel();

		try {
			// throw new \Exception("Action Empty." . $action);
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			if (empty($action)) {
				throw new \Exception("Action Empty.");
			}

			$getSalesOrder	= $salesOrdersModel->where(array('salesOrderId' => $action, 'statusId' => \SALES_ORDER_STATUS::DRAFT))->first();
			if ($getSalesOrder == null and $action != "create") {
				throw new \Exception("sales orders status not is draft");
			}

			$this->validation->setRules([
				"productId"				=> ["label" => "*productId*", "rules" => "required|min_length[1]|max_length[10]"],
				"quantity"				=> ["label" => "*Quantity*", "rules" => "required|min_length[1]|max_length[10]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$getProduct = $productsModel->where(array('productId' => $this->request->getPost("productId"), 'statusId' => 1))->first();
			if ($getProduct == null) {
				throw new \Exception("Product not valid");
			}

			if ($this->request->getPost("quantity") <= 0) {
				throw new \Exception("Quantity 0 not valid");
			}

			$salesOrderDetailId = addslashes($this->request->getPost("salesOrderDetailId"));

			//update salesOrdersDetails
			$amount = ($this->request->getPost("quantity") * $getProduct->priceSell);
			$paramUpdate = array(
				'productId'			=> $getProduct->productId,
				'productNumber'		=> $getProduct->productNumber,
				'productName'		=> $getProduct->productName,
				'productType'		=> $getProduct->productType,
				'priceCost'			=> $getProduct->priceCost,
				'priceSell'			=> $getProduct->priceSell,
				'quantity'			=> $this->request->getPost("quantity"),
				'amount'			=> \FormatCurrency($amount),
				'totalAmount'		=> $amount,
				// 'length'			=> $getProduct->length,
				// 'width'				=> $getProduct->width,
				// 'height'			=> $getProduct->height,
				// 'weight'			=> $getProduct->weight,
				'unit'				=> $getProduct->unit,
				// 'statusId'			=> \PRODUCTS::ACTIVE,
				// 'inputBy'			=> session()->get("userId"),
			);

			// if ($action == "create") {
			// $salesOrdersDetailsTempModel->where("salesOrderDetailId", $salesOrderDetailId);
			// $salesOrdersDetailsTempModel->set($paramUpdate);
			// $salesOrdersDetailsTempModel->update();
			// } else {
			// $salesOrdersDetailsModel->where("salesOrderDetailId", $salesOrderDetailId);
			// $salesOrdersDetailsModel->set($paramUpdate);
			// $salesOrdersDetailsModel->update();
			// }

			$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success", "data" => $paramUpdate));
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function cancelSalesOrders()
	{
		header('Content-Type: application/json');

		// get model table
		$salesOrdersModel		= new \App\Models\SalesOrdersModel();
		$deliveryOrdersModel		= new \App\Models\DeliveryOrdersModel();
		// $deliveryOrdersDetailsModel	= new \App\Models\DeliveryOrdersDetailsModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"salesOrderId"		=> ["label" => "*Sales Order ID*", "rules" => "required|integer|min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$salesOrderId = addslashes($this->request->getPost("salesOrderId"));

			$getSalesOrders	= $salesOrdersModel->where(array('salesOrderId' => $salesOrderId))->first();
			if ($getSalesOrders == null) {
				throw new \Exception("Sales Orders Not Found");
			}

			$getDeliveryOrders	= $deliveryOrdersModel->where(array('salesOrderId' => $salesOrderId, 'statusId!=' => 0))->first();
			if ($getDeliveryOrders != null) {
				throw new \Exception("Please Cancel Delivery Order");
			}

			$this->db->transBegin();
			$paramUpdate = array(
				'statusId'		=> \SALES_ORDER_STATUS::DRAFT
			);

			$salesOrdersModel->where("salesOrderId", $salesOrderId);
			$salesOrdersModel->set($paramUpdate);
			$salesOrdersModel->update();

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
}
