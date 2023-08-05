<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DeliveryOrders extends BaseController
{
	public function __construct()
	{
		$this->db		= \Config\Database::connect();
		$this->request	= \Config\Services::request();
		// $this->session	= \Config\Services::session();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{
		//
	}

	public function manage()
	{
		return view('deliveryOrders/deliveryOrders');
	}

	public function getJson()
	{
		// header('Content-Type: application/json');

		// helper
		Helper('web');

		// get model table
		$deliveryOrdersModel = new \App\Models\DeliveryOrdersModel();

		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'deliveryOrderId';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'desc';
		$offset = ($page - 1) * $rows;

		$result = array();
		$result['total'] = $deliveryOrdersModel->getCount();
		$row = array();

		$criteria = $deliveryOrdersModel->getAll(array("sort" => $sort, "order" => $order, "offset" => $offset, "rows" => $rows));
		foreach ($criteria as $data) {
			if ($data->statusId == \DELIVERY_ORDER_STATUS::DRAFT) {
				$status = "<div class='circle grey'></div> Draft";
			}
			if ($data->statusId == \DELIVERY_ORDER_STATUS::CONFIRM) {
				$status = "<div class='circle green'></div> Procesed";
			} else if ($data->statusId == \DELIVERY_ORDER_STATUS::DELIVERED) {
				$status = "<div class='circle blue'></div> Delivered";
			}

			$row[] = array(
				'deliveryOrderId'		=> $data->deliveryOrderId,
				'salesOrderId'			=> $data->salesOrderId,
				'salesOrderNumber'		=> $data->salesOrderNumber,
				'sourceLocationId'		=> $data->sourceLocationId,
				'deliveryOrderNumber'	=> $data->deliveryOrderNumber,
				'deliveryDate'			=> $data->deliveryDate,
				'customerId'			=> $data->customerId,
				'customerName'			=> $data->customerName,
				'customerDisplay'		=> $data->customerDisplay,
				'remark'				=> $data->remark,
				'status'				=> $status,
				'statusId'				=> $data->statusId,
				'inputBy'				=> $data->inputBy,
				'shipmentDate'			=> date('Y-m-d', strtotime($data->shipmentDate)),
				'shipmentTime'			=> date('H:i', strtotime($data->shipmentDate)),
				'deliveryDate'			=> \convertDate(($data->deliveryDate)),
				'deliveryTime'			=> \convertDate(($data->deliveryDate), 'time'),
				// 'inputDate'				=> DateFormatIndo($data->inputDate),
				// 'updateBy'				=> $data->updateBy,
				// 'updateDate'			=> date('Y-m-d', strtotime($data->updateDate))
			);
		}
		$result = array_merge($result, array('rows' => $row));
		return json_encode($result);
	}

	public function getJsonDetails()
	{
		// helper
		helper('Web');

		// get model table
		$deliveryOrdersDetailsModel = new \App\Models\DeliveryOrdersDetailsModel();
		$salesOrdersDetailsModel		= new \App\Models\SalesOrdersDetailsModel();

		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'deliveryOrderDetailId';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'desc';
		$offset = ($page - 1) * $rows;

		$result = array();
		$result['total'] = $deliveryOrdersDetailsModel->getCount();
		$row = array();

		$criteria = $deliveryOrdersDetailsModel->getAll();

		foreach ($criteria as $data) {
			$row[] = array(
				'deliveryOrderDetailId'	=> $data->deliveryOrderDetailId,
				'deliveryOrderId'		=> $data->deliveryOrderId,
				'salesOrderDetailId'	=> $data->salesOrderDetailId,
				'productId'				=> $data->productId,
				'productNumber'			=> $data->productNumber,
				'productName'			=> $data->productName,
				'ordered'				=> $data->ordered,
				'delivered'				=> $salesOrdersDetailsModel->getDelivered($data->salesOrderDetailId, $data->productId, $data->deliveryOrderDetailId),
				'quantity'				=> $data->quantity,
				'sourceLocationId'		=> $data->sourceLocationId,
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
		$deliveryOrdersModel			= new \App\Models\DeliveryOrdersModel();
		$deliveryOrdersDetailsTempModel = new \App\Models\DeliveryOrdersDetailsTempModel();
		$deliveryOrdersDetailsModel 	= new \App\Models\DeliveryOrdersDetailsModel();
		$salesOrdersDetailsModel		= new \App\Models\SalesOrdersDetailsModel();

		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'inputDate';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'asc';
		$offset = ($page - 1) * $rows;

		$result = array();
		$result['total'] = $deliveryOrdersDetailsTempModel->getCount();
		$row = array();

		$criteria = $deliveryOrdersDetailsTempModel->getAll();

		foreach ($criteria as $data) {
			$row[] = array(
				'deliveryOrderDetailId'	=> $data->deliveryOrderDetailId,
				'salesOrderDetailId'	=> $data->salesOrderDetailId,
				'productId'				=> $data->productId,
				'productNumber'			=> $data->productNumber,
				'productName'			=> $data->productName,
				'ordered'				=> $data->ordered,
				'delivered'				=> $salesOrdersDetailsModel->getDelivered($data->salesOrderDetailId, $data->productId),
				'quantity'				=> $data->quantity,
			);
		}
		$result = array_merge($result, array('rows' => $row));
		return json_encode($result);
	}

	public function deleteDetailsTempAll()
	{
		$deliveryOrdersDetailsTempModel = new \App\Models\DeliveryOrdersDetailsTempModel();
		$deliveryOrdersDetailsTempModel->where('inputBy', session()->get('userId'))->delete();
	}

	public function updateDeliveryOrders()
	{
		header('Content-Type: application/json');

		// get model table
		$deliveryOrdersModel		= new \App\Models\DeliveryOrdersModel();
		$deliveryOrdersDetailsModel	= new \App\Models\DeliveryOrdersDetailsModel();
		$salesOrdersModel			= new \App\Models\SalesOrdersModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"deliveryOrderId" 	=> ["label" => "*Delivery Order ID*", "rules" => "required|min_length[3]|max_length[255]"],
				"deliveryOrderNumber" 	=> ["label" => "*Delivery Order Number*", "rules" => "required|min_length[3]|max_length[255]"],
				"salesOrderId" 	=> ["label" => "*Sales Order ID*", "rules" => "required|min_length[3]|max_length[255]"],
				"salesOrderNumber" 	=> ["label" => "*Sales Order Number*", "rules" => "required|min_length[3]|max_length[255]"],
				"shipmentDate" 	=> ["label" => "*Shipment Date*", "rules" => "required|min_length[3]|max_length[255]"],
				"shipmentTime" 	=> ["label" => "*Shipment Time*", "rules" => "required|min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$getSalesOrdersModel = $salesOrdersModel->where(array('salesOrderId' => $this->request->getPost("salesOrderId"), 'statusId' => \SALES_ORDER_STATUS::CONFIRM))->first();
			if ($getSalesOrdersModel == null) {
				throw new \Exception("Sales Order not valid");
			}

			$getDeliveryOrdersDetailsModel = $deliveryOrdersDetailsModel->where(array('deliveryOrderId' => $this->request->getPost("deliveryOrderId")))->findAll();
			if ($getDeliveryOrdersDetailsModel == null) {
				throw new \Exception("Product details empty");
			}

			$deliveryOrderId = addslashes($this->request->getPost("deliveryOrderId"));

			//update deliveryOrders
			$paramUpdate = array(
				// 'deliveryOrderNumber'	=> $deliveryOrdersModel->autoDeliveryOrdersNumber(),
				'salesOrderId'			=> $this->request->getPost("salesOrderId"),
				'customerId'			=> $getSalesOrdersModel->customerId,
				'customerName'			=> $getSalesOrdersModel->customerName,
				'customerDisplay'		=> $getSalesOrdersModel->customerDisplay,
				'shipmentDate'			=> date('Y-m-d H:i:s', strtotime($this->request->getPost("shipmentDate") . $this->request->getPost("shipmentTime"))),
				'deliveryDate'			=> 0,
				'remark'				=> $this->request->getPost("remark"),
				// 'statusId'				=> \DELIVERY_ORDER_STATUS::DRAFT,
				'inputBy'				=> session()->get("userId"),
			);

			$deliveryOrdersModel->where("deliveryOrderId", $deliveryOrderId);
			$deliveryOrdersModel->set($paramUpdate);
			$deliveryOrdersModel->update();

			$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function createDeliveryOrders()
	{
		header('Content-Type: application/json');

		// get model table
		$deliveryOrdersModel			= new \App\Models\DeliveryOrdersModel();
		$deliveryOrdersDetailsModel		= new \App\Models\DeliveryOrdersDetailsModel();
		$deliveryOrdersDetailsTempModel	= new \App\Models\DeliveryOrdersDetailsTempModel();
		$salesOrdersModel				= new \App\Models\SalesOrdersModel();
		$salesOrdersDetailsModel		= new \App\Models\SalesOrdersDetailsModel();
		$locationsModel					= new \App\Models\LocationsModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"deliveryOrderNumber" 	=> ["label" => "*Delivery Order Number*", "rules" => "required|is_unique[delivery_orders.deliveryOrderNumber]|min_length[3]|max_length[255]"],
				"sourceLocationId"		=> ["label" => "*Source Location ID*", "rules" => "required|min_length[3]|max_length[255]"],
				"salesOrderId"			=> ["label" => "*Sales Order ID*", "rules" => "required|min_length[3]|max_length[255]"],
				"salesOrderNumber"		=> ["label" => "*Sales Order Number*", "rules" => "required|min_length[3]|max_length[255]"],
				"shipmentDate"			=> ["label" => "*Shipment Date*", "rules" => "required|min_length[3]|max_length[255]"],
				"shipmentTime"			=> ["label" => "*Shipment Time*", "rules" => "required|min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$getSalesOrdersModel = $salesOrdersModel->where(array('salesOrderId' => $this->request->getPost("salesOrderId"), 'statusId' => \SALES_ORDER_STATUS::CONFIRM))->first();
			if ($getSalesOrdersModel == null) {
				throw new \Exception("Sales Order not valid");
			}

			$getLocationModel = $locationsModel->where(array('locationId' => $this->request->getPost("sourceLocationId"), 'statusId' => 1))->first();
			if ($getLocationModel == null) {
				throw new \Exception("Location not valid");
			}

			$getDeliveryOrdersDetailsTempModel = $deliveryOrdersDetailsTempModel->getAll();

			if ($getDeliveryOrdersDetailsTempModel == null) {
				throw new \Exception("Product details empty");
			}

			$this->db->transBegin();

			// insert deliveryOrders
			$paramInsert = array(
				'deliveryOrderNumber'	=> $deliveryOrdersModel->autoDeliveryOrdersNumber(),
				'salesOrderId'			=> $this->request->getPost("salesOrderId"),
				'shipmentDate'			=> $this->request->getPost("deliveryOrderNumber"),
				'customerId'			=> $getSalesOrdersModel->customerId,
				'customerName'			=> $getSalesOrdersModel->customerName,
				'customerDisplay'		=> $getSalesOrdersModel->customerDisplay,
				'shipmentDate'			=> date('Y-m-d H:i:s', strtotime($this->request->getPost("shipmentDate") . $this->request->getPost("shipmentTime"))),
				'remark'				=> $this->request->getPost("remark"),
				'sourceLocationId'		=> $this->request->getPost("sourceLocationId"),
				'statusId'				=> \DELIVERY_ORDER_STATUS::DRAFT,
				'inputBy'				=> session()->get("userId"),
			);
			$deliveryOrdersModel->insert($paramInsert);

			// insert deliveryOrdersDetails and delete deliveryOrdersDetailsTemp
			if ($getDeliveryOrdersDetailsTempModel != null) {

				foreach ($getDeliveryOrdersDetailsTempModel as $dataTemp) {
					$delivered		= $salesOrdersDetailsModel->getDelivered($dataTemp->salesOrderDetailId, $dataTemp->productId);

					$paramDeliveryOrderDetailsTemp = array(
						'deliveryOrderId'	=> $deliveryOrdersModel->getInsertID(),
						'productId'			=> $dataTemp->productId,
						'salesOrderDetailId' => $dataTemp->salesOrderDetailId,
						'ordered'			=> $dataTemp->ordered,
						'delivered'			=> $delivered,
						'quantity'			=> $dataTemp->quantity,
						'statusId'			=> 1,
						'inputBy'			=> session()->get("userId"),
					);
					$deliveryOrdersDetailsModel->insert($paramDeliveryOrderDetailsTemp);

					// Adjustment Location Stock
					$locationsModel->adjustmentStockPhy(
						$this->request->getPost("sourceLocationId"),
						$dataTemp->productId,
						-abs($dataTemp->quantity)
					);

					// delete deliveryOrdersDetailsTemp
					$deliveryOrdersDetailsTempModel->delete($dataTemp->deliveryOrderDetailId);
				}
			}
			// insert deliveryOrdersDetails and delete deliveryOrdersDetailsTem EOF

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

	public function deleteDeliveryOrders()
	{
		header('Content-Type: application/json');

		// get model table
		$locationsModel				= new \App\Models\LocationsModel();
		$deliveryOrdersModel		= new \App\Models\DeliveryOrdersModel();
		$deliveryOrdersDetailsModel	= new \App\Models\DeliveryOrdersDetailsModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"deliveryOrderId" 	=> ["label" => "*Delivery Order ID*", "rules" => "required|min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$deliveryOrderId = addslashes($this->request->getPost("deliveryOrderId"));

			$getDeliveryOrderModel = $deliveryOrdersModel->where(array('deliveryOrderId' => $deliveryOrderId))->first();
			if ($getDeliveryOrderModel == null) {
				throw new \Exception("DeliveryOrder not valid");
			}

			if ($getDeliveryOrderModel->statusId != \DELIVERY_ORDER_STATUS::DRAFT) {
				throw new \Exception("Delivery orders status not is draft");
			}

			$getDeliveryOrderDetailModel = $deliveryOrdersDetailsModel->where(array('deliveryOrderId' => $deliveryOrderId))->findAll();
			if ($getDeliveryOrderDetailModel == null) {
				throw new \Exception("DeliveryOrderDetail not valid");
			}

			$this->db->transBegin();

			if ($getDeliveryOrderDetailModel != null) {

				foreach ($getDeliveryOrderDetailModel as $dataTemp) {
					// Adjustment Location Stock
					$locationsModel->adjustmentStockPhy(
						$getDeliveryOrderModel->sourceLocationId,
						$dataTemp->productId,
						+abs($dataTemp->quantity)
					);
				}
			}

			// delete deliveryOrders
			$deliveryOrdersModel->delete($deliveryOrderId);
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

	public function viewDeliveryOrders($action = "")
	{
		// get model
		$deliveryOrdersModel	= new \App\Models\DeliveryOrdersModel();
		$approvalsModel			= new \App\Models\ApprovalsModel();

		$getDeliveryOrders		= $deliveryOrdersModel->where(array('deliveryOrderId' => $action))->first();
		$getApproval			= $approvalsModel->where(array('option' => \APPROVAL::DELIVERY_ORDERS, 'optionId' => $action, 'statusId' => 0))->orderBy('sort', 'asc')->first();

		if ($getDeliveryOrders->statusId > \SALES_ORDER_STATUS::DRAFT) {
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
			'deliveryOrderNumber'	=> $getDeliveryOrders->deliveryOrderNumber,
		);
		return view("deliveryOrders/viewDeliveryOrders", $data);
	}

	public function approvalDeliveryOrders()
	{
		// get model
		$deliveryOrdersModel 	= new \App\Models\DeliveryOrdersModel();
		$approvalsModel			= new \App\Models\ApprovalsModel();

		try {
			if (empty($this->request->getPost())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"deliveryOrderId"		=> ["label" => "*Delivery Order ID*", "rules" => "required|min_length[3]|max_length[10]"],
				"approvalHeader"		=> ["label" => "*approvalHeader*", "rules" => "required|min_length[1]|max_length[100]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			// kasih signature biar keren
			$sign = hash('sha256', $this->request->getPost("approvalId") . $this->request->getPost("deliveryOrderId") . APIKEY);
			if ($sign != $this->request->getPost("approvalHeader")) {
				throw new \Exception("Error");
			}

			$getSalesOrder	= $deliveryOrdersModel->where(array('deliveryOrderId' => $this->request->getPost("deliveryOrderId"), 'statusId' => \DELIVERY_ORDER_STATUS::DRAFT))->first();
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

				// $deliveryOrdersModel->where("deliveryOrderId", $this->request->getPost("deliveryOrderId"));
				// $deliveryOrdersModel->set($paramUpdate);
				// $deliveryOrdersModel->update();
				$deliveryOrdersModel->changeStatus($this->request->getPost("deliveryOrderId"), \DELIVERY_ORDER_STATUS::CONFIRM);
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

	public function formDeliveryOrders($action = "")
	{
		// get model table
		$deliveryOrdersModel = new \App\Models\DeliveryOrdersModel();

		if ($action == "create") {
			// clear table deliveryOrders_details_temp
			$this->deleteDetailsTempAll();

			$data['urlDatagrid'] = base_url('deliveryOrders/getJsonDetailsTemp');
		} else {
			$data['urlDatagrid'] = base_url('deliveryOrders/getJsonDetails?deliveryOrderId=' . $action);
		}

		$data['action']	= $action;
		$data['deliveryOrderNumber']	= $deliveryOrdersModel->autoDeliveryOrdersNumber();
		return view("deliveryOrders/addDeliveryOrders", $data);
	}

	public function formDeliveryOrdersDetails($action = "")
	{
		// get model table
		$locationsModel				= new \App\Models\LocationsModel();
		$locationStockModel			= new \App\Models\LocationStockModel();
		$deliveryOrdersDetailsModel	= new \App\Models\DeliveryOrdersDetailsModel();

		$salesOrderId			= $this->request->getGet('salesOrderId');
		$sourceLocationId		= $this->request->getGet('sourceLocationId');
		$deliveryOrderDetailId	= $this->request->getGet('deliveryOrderDetailId');

		try {

			$getLocation = $locationsModel->where(array('locationId' => $sourceLocationId, 'statusId' => 1))->first();
			if ($getLocation == null) {
				throw new \Exception("Source Location not valid");
			}

			if ($action == "create") {
				$data['stockPhy']		= 0;
			} else {
				$data['stockPhy']		= $locationStockModel->getStockPhy($sourceLocationId, $getDeliveryOrderDetail->productId);

				$getDeliveryOrderDetail = $deliveryOrdersDetailsModel->where(array('deliveryOrderDetailId' => $deliveryOrderDetailId, 'statusId' => 1))->first();
				if ($getDeliveryOrderDetail == null) {
					throw new \Exception("Delivery Order not valid");
				}
			}

			$data['urlProductId']		= base_url('combogrid/combogridProductsToShipment/' . $action . '?salesOrderId=' . $salesOrderId . '&deliveryOrderDetailId=' . $deliveryOrderDetailId . '&sourceLocationId=' . $sourceLocationId);
			$data['sourceLocation']		= $getLocation->locationName;
			$data['sourceLocationId']	= $sourceLocationId;
			return view("deliveryOrders/addDeliveryOrdersDetails", $data);
		} catch (\Exception $ex) {
			echo $ex->getMessage();
		}
	}

	public function formMarkDelivered($action = "")
	{
		// get model table
		$deliveryOrdersModel = new \App\Models\DeliveryOrdersModel();

		if ($action == "create") {
			// clear table deliveryOrders_details_temp
			$this->deleteDetailsTempAll();

			$data['urlDatagrid'] = base_url('deliveryOrders/getJsonDetailsTemp');
		} else {
			$data['urlDatagrid'] = base_url('deliveryOrders/getJsonDetails?deliveryOrderId=' . $action);
		}

		$data['action']	= $action;
		$data['deliveryOrderNumber']	= $deliveryOrdersModel->autoDeliveryOrdersNumber();
		return view("deliveryOrders/markAsDelivered", $data);
	}

	public function createDeliveryOrdersDetails($action = "")
	{
		header('Content-Type: application/json');

		// get model table
		$deliveryOrdersModel			= new \App\Models\DeliveryOrdersModel();
		$deliveryOrdersDetailsModel		= new \App\Models\DeliveryOrdersDetailsModel();
		$deliveryOrdersDetailsTempModel	= new \App\Models\DeliveryOrdersDetailsTempModel();
		$productsModel					= new \App\Models\ProductsModel();
		$salesOrdersModel				= new \App\Models\SalesOrdersModel();
		$salesOrdersDetailsModel		= new \App\Models\SalesOrdersDetailsModel();
		$locationStockModel				= new \App\Models\LocationStockModel();
		$locationsModel					= new \App\Models\LocationsModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			if (empty($action)) {
				throw new \Exception("Action Empty.");
			}

			$this->validation->setRules([
				"productId"				=> ["label" => "*Product ID*", "rules" => "required|integer|min_length[3]|max_length[255]"],
				"sourceLocationId"		=> ["label" => "*Source Location ID*", "rules" => "required|integer|min_length[3]|max_length[255]"],
				"salesOrderDetailId"	=> ["label" => "*Sales Order Detail ID*", "rules" => "required|integer|min_length[3]|max_length[255]"],
				"quantity" 				=> ["label" => "*Quantity*", "rules" => "required|integer|min_length[1]|max_length[255]"],
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

			$getSalesOrdersDetailsModel = $salesOrdersDetailsModel->where(array('salesOrderDetailId' => $this->request->getPost("salesOrderDetailId"), 'statusId' => 1))->first();
			if ($getSalesOrdersDetailsModel == null) {
				throw new \Exception("Sales Order Detail not valid");
			}

			if ($this->request->getPost("quantity") <= 0) {
				throw new \Exception("Quantity 0 not valid");
			}

			if ($this->request->getPost("quantity") > $getSalesOrdersDetailsModel->quantity) {
				throw new \Exception("Over Quantity");
			}

			$delivered		= $salesOrdersDetailsModel->getDelivered($getSalesOrdersDetailsModel->salesOrderDetailId, $this->request->getPost("productId"), $deliveryOrderDetailId);
			$getAvailable	= ($getSalesOrdersDetailsModel->quantity - $delivered);

			if ($this->request->getPost("quantity") > $getAvailable) {
				throw new \Exception("Over Partially Quantity");
			}

			$getStock = $locationStockModel->getStockPhy($this->request->getPost("sourceLocationId"), $this->request->getPost("productId"));

			if ($this->request->getPost("quantity") > $getStock) {
				throw new \Exception("Over From Stock Location");
			}

			// insert deliveryOrders
			$paramInsert = array(
				'productId'			=> $this->request->getPost("productId"),
				'salesOrderDetailId' => $getSalesOrdersDetailsModel->salesOrderDetailId,
				'ordered'			=> $getSalesOrdersDetailsModel->quantity,
				'delivered'			=> $delivered,
				'quantity'			=> $this->request->getPost("quantity"),
				'statusId'			=> 1,
				'inputBy'			=> session()->get("userId"),
			);

			$this->db->transBegin();

			if ($action == "create") {
				$insert = $deliveryOrdersDetailsTempModel->insert($paramInsert);
			} else {
				$getDeliveryOrder = $deliveryOrdersModel->where(array('deliveryOrderId' => $action))->first();
				if ($getDeliveryOrder == null) {
					throw new \Exception("Delivery Order not valid");
				}

				$paramInsert["deliveryOrderId"] = $action;
				$deliveryOrdersDetailsModel->insert($paramInsert);

				// Adjustment Location Stock (-)
				$locationsModel->adjustmentStockPhy(
					$this->request->getPost("sourceLocationId"),
					$this->request->getPost("productId"),
					-abs($this->request->getPost("quantity"))
				);
			}

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

	public function deleteDeliveryOrdersDetails($action = "")
	{
		header('Content-Type: application/json');

		// get model table
		$deliveryOrdersModel			= new \App\Models\DeliveryOrdersModel();
		$deliveryOrdersDetailsModel		= new \App\Models\DeliveryOrdersDetailsModel();
		$deliveryOrdersDetailsTempModel	= new \App\Models\DeliveryOrdersDetailsTempModel();
		$locationsModel					= new \App\Models\LocationsModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			if (empty($action)) {
				throw new \Exception("Action Empty.");
			}

			$deliveryOrderDetailId = addslashes($this->request->getPost("deliveryOrderDetailId"));

			if ($action == "create") {

				// delete table `deliveryOrdersDetailsTemp`
				$deleteTemp = $deliveryOrdersDetailsTempModel->delete($deliveryOrderDetailId);
				if ($deleteTemp) {
					$returnValue = json_encode(array('status' => "success", "msg" => "Delete Success"));
				} else {
					foreach ($deliveryOrdersDetailsTempModel->errors() as $error) {
					}
					throw new \Exception($error);
				}
			} else {
				$this->db->transBegin();

				// restore quantity stock product
				$getDeliveryOrderDetailModel = $deliveryOrdersDetailsModel->getResultData(array('deliveryOrderId' => $deliveryOrderId, 'statusId' => 1))->getResult();
				if ($getDeliveryOrderDetailModel == null) {
					throw new \Exception("DeliveryOrderDetail not valid");
				}

				if ($getDeliveryOrderDetailModel != null) {

					foreach ($getDeliveryOrderDetailModel as $dataTemp) {
						// Adjustment Location Stock
						$locationsModel->adjustmentStockPhy(
							$dataTemp->sourceLocationId,
							$dataTemp->productId,
							+abs($dataTemp->quantity)
						);
					}
				}

				// delete table `deliveryOrdersDetails`
				$deliveryOrdersDetailsModel->delete($deliveryOrderDetailId);
				if ($this->db->transStatus() === false) {
					$this->db->transRollback();
					$returnValue = json_encode(array('status' => "failed", "msg" => "Error data"));
				} else {
					$this->db->transCommit();
					$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
				}
			}
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function updateDeliveryOrdersDetails($action = "")
	{
		header('Content-Type: application/json');

		// get model table
		$deliveryOrdersDetailsModel		= new \App\Models\DeliveryOrdersDetailsModel();
		$deliveryOrdersDetailsTempModel	= new \App\Models\DeliveryOrdersDetailsTempModel();
		$salesOrdersModel				= new \App\Models\SalesOrdersModel();
		$salesOrdersDetailsModel 		= new \App\Models\SalesOrdersDetailsModel();
		$salesOrdersDetailsTempModel	= new \App\Models\SalesOrdersDetailsTempModel();
		$productsModel					= new \App\Models\ProductsModel();
		$locationsModel					= new \App\Models\LocationsModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			if (empty($action)) {
				throw new \Exception("Action Empty.");
			}

			$this->validation->setRules([
				"deliveryOrderDetailId"	=> ["label" => "*Delivery OrderDetail Id*", "rules" => "required|min_length[3]|max_length[255]"],
				"productId"				=> ["label" => "*Product ID*", "rules" => "required|min_length[3]|max_length[255]"],
				"salesOrderDetailId"	=> ["label" => "*Sales Order Detail ID*", "rules" => "required|min_length[3]|max_length[255]"],
				"quantity"				=> ["label" => "*Quantity*", "rules" => "required|min_length[1]|max_length[255]"],
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

			$getSalesOrdersDetailsModel = $salesOrdersDetailsModel->where(array('salesOrderDetailId' => $this->request->getPost("salesOrderDetailId"), 'statusId' => 1))->first();
			if ($getSalesOrdersDetailsModel == null) {
				throw new \Exception("Sales Order Detail not valid");
			}

			if ($this->request->getPost("quantity") <= 0) {
				throw new \Exception("Quantity 0 not valid");
			}

			if ($this->request->getPost("quantity") > $getSalesOrdersDetailsModel->quantity) {
				throw new \Exception("Over Quantity");
			}

			$deliveryOrderDetailId = addslashes($this->request->getPost("deliveryOrderDetailId"));

			$delivered		= $salesOrdersDetailsModel->getDelivered($getSalesOrdersDetailsModel->salesOrderDetailId, $this->request->getPost("productId"), $deliveryOrderDetailId);
			$getAvailable	= ($getSalesOrdersDetailsModel->quantity - $delivered);

			if ($this->request->getPost("quantity") > $getAvailable) {
				throw new \Exception("Over Partially Quantity");
			}

			//update `deliveryOrdersDetailsTemp`
			$paramUpdate = array(
				'productId'			=> $this->request->getPost("productId"),
				'salesOrderDetailId' => $getSalesOrdersDetailsModel->salesOrderDetailId,
				'ordered'			=> $getSalesOrdersDetailsModel->quantity,
				'delivered'			=> $delivered,
				'quantity'			=> $this->request->getPost("quantity"),
				'statusId'			=> 1,
				'updateBy'			=> session()->get("userId"),
			);

			if ($action == "create") {

				$deliveryOrdersDetailsTempModel->where("deliveryOrderDetailId", $deliveryOrderDetailId);
				$deliveryOrdersDetailsTempModel->set($paramUpdate);
				$deliveryOrdersDetailsTempModel->update();
			} else {
				$getDeliveryOrderDetailModel = $deliveryOrdersDetailsModel->getResultData(array('deliveryOrderDetailId' => $deliveryOrderDetailId, 'statusId' => 1))->getRow();
				if ($getDeliveryOrderDetailModel == null) {
					throw new \Exception("DeliveryOrderDetail not valid");
				}

				$this->db->transBegin();
				// Adjustment Location Stock (+)
				$locationsModel->adjustmentStockPhy(
					$getDeliveryOrderDetailModel->sourceLocationId,
					$getDeliveryOrderDetailModel->productId,
					+abs($getDeliveryOrderDetailModel->quantity)
				);

				// Adjustment Location Stock (-)
				$locationsModel->adjustmentStockPhy(
					$getDeliveryOrderDetailModel->sourceLocationId,
					$this->request->getPost("productId"),
					-abs($this->request->getPost("quantity"))
				);

				// $paramUpdate["deliveryOrderId"] = $this->request->getPost("deliveryOrderId");
				$deliveryOrdersDetailsModel->where("deliveryOrderDetailId", $deliveryOrderDetailId);
				$deliveryOrdersDetailsModel->set($paramUpdate);
				$deliveryOrdersDetailsModel->update();

				if ($this->db->transStatus() === false) {
					$this->db->transRollback();
					$returnValue = json_encode(array('status' => "failed", "msg" => "Error data"));
				} else {
					$this->db->transCommit();
					$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
				}
			}

			$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function markAsDelivered()
	{
		header('Content-Type: application/json');

		// get model table
		$deliveryOrdersModel		= new \App\Models\DeliveryOrdersModel();
		$deliveryOrdersDetailsModel	= new \App\Models\DeliveryOrdersDetailsModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}


			$this->validation->setRules([
				"deliveryOrderId"		=> ["label" => "*Delivery Order ID*", "rules" => "required|integer|min_length[3]|max_length[255]"],
				"deliveryRealDate"		=> ["label" => "*Delivery Date*", "rules" => "required|min_length[3]|max_length[255]"],
				"deliveryRealTime"		=> ["label" => "*Delivery Time*", "rules" => "required|min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$deliveryOrderId = addslashes($this->request->getPost("deliveryOrderId"));

			$getDeliveryOrders	= $deliveryOrdersModel->where(array('deliveryOrderId' => $deliveryOrderId))->first();
			if ($getDeliveryOrders == null) {
				throw new \Exception("Delivery Order not valid");
			}

			//update `deliveryOrdersModel`
			$getDeliveryOrderDetailModel = $deliveryOrdersDetailsModel->where(array('deliveryOrderId' => $deliveryOrderId, 'statusId' => 1))->first();
			if ($getDeliveryOrderDetailModel == null) {
				throw new \Exception("DeliveryOrderDetail not valid");
			}

			$this->db->transBegin();
			$paramUpdate = array(
				'statusId'		=> \DELIVERY_ORDER_STATUS::DELIVERED,
				'deliveryDate'	=> date('Y-m-d H:i:s', strtotime($this->request->getPost("deliveryRealDate") . $this->request->getPost("deliveryRealTime"))),
			);

			$deliveryOrdersModel->where("deliveryOrderId", $deliveryOrderId);
			$deliveryOrdersModel->set($paramUpdate);
			$deliveryOrdersModel->update();

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

	public function markAsUndeliveryOrders()
	{
		header('Content-Type: application/json');

		// get model table
		$deliveryOrdersModel		= new \App\Models\DeliveryOrdersModel();
		$deliveryOrdersDetailsModel	= new \App\Models\DeliveryOrdersDetailsModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"deliveryOrderId"		=> ["label" => "*Delivery Order ID*", "rules" => "required|integer|min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$deliveryOrderId = addslashes($this->request->getPost("deliveryOrderId"));

			$getDeliveryOrders	= $deliveryOrdersModel->where(array('deliveryOrderId' => $deliveryOrderId))->first();
			if ($getDeliveryOrders == null) {
				throw new \Exception("Delivery Order not valid");
			}

			$getDeliveryOrderDetailModel = $deliveryOrdersDetailsModel->where(array('deliveryOrderId' => $deliveryOrderId, 'statusId' => 1))->first();
			if ($getDeliveryOrderDetailModel == null) {
				throw new \Exception("DeliveryOrderDetail not valid");
			}

			$this->db->transBegin();
			$paramUpdate = array(
				'statusId'		=> \DELIVERY_ORDER_STATUS::CONFIRM,
				'deliveryDate'	=> date('Y-m-d H:i:s', "0000-00-00 00:00:00"),
			);

			$deliveryOrdersModel->where("deliveryOrderId", $deliveryOrderId);
			$deliveryOrdersModel->set($paramUpdate);
			$deliveryOrdersModel->update();

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

	public function cancelDeliveryOrders()
	{
		header('Content-Type: application/json');

		// get model table
		$deliveryOrdersModel		= new \App\Models\DeliveryOrdersModel();
		$deliveryOrdersDetailsModel	= new \App\Models\DeliveryOrdersDetailsModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"deliveryOrderId"		=> ["label" => "*Delivery Order ID*", "rules" => "required|integer|min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$deliveryOrderId = addslashes($this->request->getPost("deliveryOrderId"));

			$getDeliveryOrders	= $deliveryOrdersModel->where(array('deliveryOrderId' => $deliveryOrderId))->first();
			if ($getDeliveryOrders == null) {
				throw new \Exception("Delivery Order not valid");
			}

			$getDeliveryOrderDetailModel = $deliveryOrdersDetailsModel->where(array('deliveryOrderId' => $deliveryOrderId, 'statusId' => 1))->first();
			if ($getDeliveryOrderDetailModel == null) {
				throw new \Exception("DeliveryOrderDetail not valid");
			}

			$this->db->transBegin();
			$paramUpdate = array(
				'statusId'		=> \DELIVERY_ORDER_STATUS::DRAFT,
				'deliveryDate'	=> date('Y-m-d H:i:s', "0000-00-00 00:00:00"),
			);

			$deliveryOrdersModel->where("deliveryOrderId", $deliveryOrderId);
			$deliveryOrdersModel->set($paramUpdate);
			$deliveryOrdersModel->update();

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
