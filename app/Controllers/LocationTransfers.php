<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LocationTransfers extends BaseController
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
		return view('locationTransfers/locationTransfers');
	}

	public function getJson()
	{
		// header('Content-Type: application/json');

		// get model table
		$locationTransfersModel = new \App\Models\LocationTransfersModel();

		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'inputDate';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'desc';
		$offset = ($page - 1) * $rows;

		$result = array();
		$result['total'] = $locationTransfersModel->getCount();
		$row = array();

		$criteria = $locationTransfersModel->getAll();

		foreach ($criteria as $data) {
			if ($data->statusId == \LOCATION::ACTIVE) {
				$status = "<div class='circle green'></div> Active";
			} else if ($data->statusId == \LOCATION::DISABLED) {
				$status = "<div class='circle red'></div> Disable";
			}

			$row[] = array(
				'locationTransferId'		=> $data->locationTransferId,
				'reffNumber'				=> $data->reffNumber,
				'transferDate'				=> date('Y-m-d', strtotime($data->transferDate)),
				'remark'					=> $data->remark,
				'sourceLocationId'			=> $data->sourceLocationId,
				'destinationLocationId'		=> $data->destinationLocationId,
				'sourceLocationName'		=> $data->sourceLocationName,
				'destinationLocationName'	=> $data->destinationLocationName,
				'status'			=> $status,
				'statusId'			=> $data->statusId,
				'inputUserName'		=> $data->userName,
				'inputBy'			=> $data->inputBy,
				'inputDate'			=> date('H:i:s', strtotime($data->inputDate)),
				'updateBy'			=> $data->updateBy,
				'updateDate'		=> date('Y-m-d', strtotime($data->updateDate))
			);
		}
		$result = array_merge($result, array('rows' => $row));
		return json_encode($result);
	}

	public function getJsonDetailsTemp()
	{
		// get model table
		$locationTransfersDetailsTempModel	= new \App\Models\LocationTransfersDetailsTempModel();
		$productsModel						= new \App\Models\ProductsModel();

		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'inputDate';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'asc';
		$offset = ($page - 1) * $rows;

		$result = array();
		$result['total'] = $locationTransfersDetailsTempModel->getCount();
		$row = array();

		$criteria = $locationTransfersDetailsTempModel->getAll();

		foreach ($criteria as $data) {
			// if ($data->statusId == \USERS::ACTIVE) {
			// 	$status = "<div class='circle green'></div> Active";
			// } else if ($data->statusId == \USERS::DISABLED) {
			// 	$status = "<div class='circle red'></div> Disable";
			// }

			$row[] = array(
				'locationTransferDetailId' => $data->locationTransferDetailId,
				'productId'                => $data->productId,
				'productNumber'            => $data->productNumber,
				'productName'              => $data->productName,
				'sourceStock'              => $data->sourceStock,
				'destinationStock'         => $data->destinationStock,
				'transferQuantity'         => $data->transferQuantity,
			);
		}
		$result = array_merge($result, array('rows' => $row));
		return json_encode($result);
	}

	public function getJsonDetails()
	{
		// get model table
		$locationTransfersDetailsModel	= new \App\Models\LocationTransfersDetailsModel();
		$productsModel						= new \App\Models\ProductsModel();

		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'inputDate';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'asc';
		$offset = ($page - 1) * $rows;

		$result = array();
		$result['total'] = $locationTransfersDetailsModel->getCount();
		$row = array();

		$criteria = $locationTransfersDetailsModel->getAll();

		foreach ($criteria as $data) {
			// if ($data->statusId == \USERS::ACTIVE) {
			// 	$status = "<div class='circle green'></div> Active";
			// } else if ($data->statusId == \USERS::DISABLED) {
			// 	$status = "<div class='circle red'></div> Disable";
			// }

			$row[] = array(
				'locationTransferDetailId'	=> $data->locationTransferDetailId,
				'productId'				=> $data->productId,
				'productNumber'			=> $data->productNumber,
				'productName'			=> $data->productName,
				'sourceStock'			=> $data->sourceStock,
				'destinationStock'		=> $data->destinationStock,
				'transferQuantity'		=> $data->transferQuantity,
			);
		}
		$result = array_merge($result, array('rows' => $row));
		return json_encode($result);
	}

	/*
	public function updateLocationTransfers()
    {
		header('Content-Type: application/json');
		
		// get model table
		$locationTransfersModel = new \App\Models\LocationTransfersModel();
		
		try
		{
			if(empty( $this->request->getPostGet() )) {
				throw new \Exception("Data Empty.");
			}
			
			$this->validation->setRules([
                "reffNumber"			=> ["label" => "*Reff Number*", "rules" => "required|min_length[3]|max_length[255]"],
				"transferDate"			=> ["label" => "*Transfer Date*", "rules" => "required"],
				// "sourceLocationId" 		=> ["label" => "*Source Location Name*", "rules" => "required|min_length[3]|max_length[255]"],
                // "destinationLocationId"	=> ["label" => "*Destination Location Name*", "rules" => "required|min_length[3]|max_length[255]"],
                "locationTransferId"	=> ["label" => "*Remark*", "rules" => "min_length[3]|max_length[255]"],
            ]);
			
			if(!$this->validation->withRequest($this->request)->run()){
				foreach ($this->validation->getErrors() as $error) {}
				throw new \Exception($error);
			}
			
			$locationTransferId = addslashes($this->request->getPost("locationTransferId"));
			
			//update location
			$paramUpdate = array(
				'transferDate'		=> $this->request->getPost("transferDate"),
				'remark'			=> $this->request->getPost("remark"),
				'updateBy'			=> session()->get("userId"),
			);
			
			$locationTransfersModel->where("locationTransferId", $locationTransferId);
			$locationTransfersModel->set($paramUpdate);
			$locationTransfersModel->update();
			
			$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
		}
		catch(\Exception $ex)
		{
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}
		
		echo $returnValue;
    }
	*/

	public function createLocationTransfers()
	{
		header('Content-Type: application/json');

		// get model table
		$locationTransfersModel 			= new \App\Models\LocationTransfersModel();
		$locationTransfersDetailsModel		= new \App\Models\LocationTransfersDetailsModel();
		$locationTransfersDetailsTempModel	= new \App\Models\LocationTransfersDetailsTempModel();
		$locationsModel						= new \App\Models\LocationsModel();
		$locationStockModel					= new \App\Models\LocationStockModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			// log_message('error', json_encode($this->request->getPostGet()));
			$this->validation->setRules([
				"reffNumber"			=> ["label" => "*Reff Number*", "rules" => "required|min_length[3]|max_length[255]"],
				"transferDate"			=> ["label" => "*Transfer Date*", "rules" => "required"],
				"sourceLocationId"		=> ["label" => "*Source Location Name*", "rules" => "required|min_length[3]|max_length[255]"],
				"destinationLocationId"	=> ["label" => "*Destination Location Name*", "rules" => "required|min_length[3]|max_length[255]"],
				// "remark" 	=> ["label" => "*Remark*", "rules" => "min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$getLocationTransfersDetailsTempModel = $locationTransfersDetailsTempModel->getAll();

			if ($getLocationTransfersDetailsTempModel == null) {
				throw new \Exception("Product details empty");
			}

			$getSource = $locationsModel->where(array('locationId' => $this->request->getPost("sourceLocationId"), 'statusId' => 1))->first();
			if ($getSource == null) {
				throw new \Exception("Source Location empty");
			}

			$getDestination = $locationsModel->where(array('locationId' => $this->request->getPost("destinationLocationId"), 'statusId' => 1))->first();
			if ($getDestination == null) {
				throw new \Exception("Destination Location empty");
			}

			// $userId = addslashes($this->request->getPost("userId"));

			$this->db->transBegin();

			// insert location
			$paramInsert = array(
				'reffNumber'				=> $this->request->getPost("reffNumber"),
				'transferDate'				=> $this->request->getPost("transferDate"),
				'sourceLocationId'			=> $this->request->getPost("sourceLocationId"),
				'destinationLocationId'		=> $this->request->getPost("destinationLocationId"),
				'sourceLocationName'		=> $getSource->locationName,
				'destinationLocationName'	=> $getDestination->locationName,
				'remark'					=> $this->request->getPost("remark"),
				'statusId'					=> 1,
				'inputBy'					=> session()->get("userId"),
			);

			$locationTransfersModel->insert($paramInsert);

			// insert locationTransfersDetails and delete locationTransfersDetailsTemp
			if ($getLocationTransfersDetailsTempModel != null) {

				foreach ($getLocationTransfersDetailsTempModel as $dataTemp) {
					$paramLocationTransferTemp = array(
						'locationTransferId'	=> $locationTransfersModel->getInsertID(),
						'productId'			=> $dataTemp->productId,
						'productNumber'		=> $dataTemp->productNumber,
						'productName'		=> $dataTemp->productName,
						'productType'		=> $dataTemp->productType,
						'priceCost'			=> $dataTemp->priceCost,
						'priceSell'			=> $dataTemp->priceSell,
						'sourceStock'		=> $dataTemp->sourceStock,
						'destinationStock'	=> $dataTemp->destinationStock,
						'transferQuantity'	=> $dataTemp->transferQuantity,
						'length'			=> $dataTemp->length,
						'width'				=> $dataTemp->width,
						'height'			=> $dataTemp->height,
						'weight'			=> $dataTemp->weight,
						'unit'				=> $dataTemp->unit,
						'statusId'			=> 1,
						'inputBy'			=> session()->get("userId"),
					);
					$locationTransfersDetailsModel->insert($paramLocationTransferTemp);

					// Move Stock
					$locationStockModel->moveStock(
						$this->request->getPost("sourceLocationId"),
						$this->request->getPost("destinationLocationId"),
						$dataTemp->productId,
						$dataTemp->transferQuantity
					);

					// delete locationTransfersDetailsTemp
					$locationTransfersDetailsTempModel->delete($dataTemp->locationTransferDetailId);
				}
			}
			// insert locationTransfersDetails and delete locationTransfersDetailsTemp EOF

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

		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function deleteLocationTransfers()
	{
		header('Content-Type: application/json');

		// get model table
		$locationTransfers = new \App\Models\LocationTransfersModel();
		$locationTransfersDetails = new \App\Models\LocationTransfersDetailsModel();
		$locationStockModel = new \App\Models\LocationStockModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
				// throw new \Exception(($this->request->getJson("locationId")));
			}

			$locationTransferId = addslashes($this->request->getPost("locationTransferId"));

			$getLocationTransfers = $locationTransfers->where(array('locationTransferId' => $locationTransferId, 'statusId' => 1))->first();
			if ($getLocationTransfers == null) {
				throw new \Exception("Location Transfer empty");
			}

			$getLocationTransfersDetails = $locationTransfersDetails->where(array('locationTransferId' => $locationTransferId, 'statusId' => 1))->findAll();
			if ($getLocationTransfersDetails == null) {
				throw new \Exception("Location Transfer Detail empty");
			}

			$this->db->transBegin();

			foreach ($getLocationTransfersDetails as $dataTransDetail) {
				// log_message('error', json_encode($locationTransferId));
				// Move Stock
				// moveStock($source, $destination, $productId, $stock);
				$locationStockModel->moveStock(
					$getLocationTransfers->destinationLocationId,
					$getLocationTransfers->sourceLocationId,
					$dataTransDetail->productId,
					$dataTransDetail->transferQuantity
				);
				$locationTransfersDetails->delete($dataTransDetail->locationTransferDetailId);
			}

			// delete location
			$delete = $locationTransfers->delete($locationTransferId);
			if (!$delete) {
				foreach ($customersModel->errors() as $error) {
				}
				throw new \Exception($error);
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

	public function formLocationTransfers($action = "")
	{
		$locationTransfersModel	= new \App\Models\LocationTransfersModel();

		if ($action == "create") {
			// log_message('error', session()->get('userId'));
			$locationTransfersDetailsTempModel	= new \App\Models\LocationTransfersDetailsTempModel();
			$locationTransfersDetailsTempModel->where('inputBy', session()->get('userId'))->delete();

			$data['urlDatagrid'] = base_url('locationtransfers/getJsonDetailsTemp');
		} else {
			$data['urlDatagrid'] = base_url('locationtransfers/getJsonDetails');
		}

		$data['action']	= $action;
		$data['locationTransferNumber']	= $locationTransfersModel->autoLocationTransferNumber();
		return view("locationTransfers/addLocationTransfers", $data);
	}

	// details
	public function formLocationTransferDetails($action = "")
	{
		// $data['urlProductId'] = ""; ///base_url('combogrid/combogridProductsSalesOrdersDetails/' . $action);
		$data['source'] = $this->request->getGet('source');
		$data['destination'] = $this->request->getGet('destination');
		return view("locationTransfers/addLocationTransfersDetails", $data);
	}

	public function createLocationTransferDetails($action = "")
	{
		// log_message('error', json_encode($this->request->getPostGet()));
		// $returnValue = json_encode(array('isError' => true, 'status' => "failed", "msg" => "Delete Success"));

		// echo $returnValue;

		// get model table
		$locationTransfersDetailsTempModel	= new \App\Models\LocationTransfersDetailsTempModel();
		$productsModel						= new \App\Models\ProductsModel();

		$getProduct = $productsModel->where(array('productId' => $this->request->getPost("productId"), 'statusId' => 1))->first();
		if ($getProduct == null) {
			throw new \Exception("Product not valid");
		}

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			if ($this->request->getPostGet('sourceStock') < $this->request->getPostGet('transferQuantity')) {
				throw new \Exception("You do not have sufficient stock to create out-transactions for the products.");
				throw new \Exception("Transactions cannot be created with Zero Quantity");
			}

			if ($this->request->getPostGet('transferQuantity') <= 0) {
				throw new \Exception("Transactions cannot be created with Zero Quantity");
			}

			// $productId = addslashes($this->request->getPost("productId"));

			$this->db->transBegin();

			// insert locationTransfersDetailsTempModel
			$paramInsert = array(
				'productId'			=> $getProduct->productId,
				'productNumber'		=> $getProduct->productNumber,
				'productName'		=> $getProduct->productName,
				'productType'		=> $getProduct->productType,
				'priceCost'			=> $getProduct->priceCost,
				'priceSell'			=> $getProduct->priceSell,
				'sourceStock'		=> $this->request->getPost("sourceStock"),
				'destinationStock'	=> $this->request->getPost("destinationStock"),
				'transferQuantity'	=> $this->request->getPost("transferQuantity"),
				'length'			=> $getProduct->length,
				'width'				=> $getProduct->width,
				'height'			=> $getProduct->height,
				'weight'			=> $getProduct->weight,
				'unit'				=> $getProduct->unit,
				'inputBy'			=> session()->get("userId"),
			);
			if ($action == "create") {

				// insert table `locationTransfersDetailsTemp`
				$locationTransfersDetailsTempModel->insert($paramInsert);
			} else {

				// insert table `salesOrdersDetails`
				// $paramInsert["salesOrderId"] = $action;
				// $salesOrdersDetailsModel->insert($paramInsert);

			}
			// insert locationTransfersDetailsTempModel EOF

			if ($this->db->transStatus() === false) {
				$this->db->transRollback();
				$returnValue = json_encode(array('status' => "failed", "msg" => "Error data"));
			} else {
				$this->db->transCommit();
				$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
			}
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('isError' => true, 'status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function deleteLocationTransferDetails($action = "")
	{
		header('Content-Type: application/json');

		// get model table
		$locationTransfersDetailsModel		= new \App\Models\LocationTransfersDetailsModel();
		$locationTransfersDetailsTempModel	= new \App\Models\LocationTransfersDetailsTempModel();

		try {
			if (empty($this->request->getPost())) {
				throw new \Exception("Data Empty.");
			}

			if (empty($action)) {
				throw new \Exception("Action Empty.");
			}

			// $getSalesOrder	= $salesOrdersModel->where(array('salesOrderId' => $action, 'statusId' => \SALES_ORDER_STATUS::DRAFT))->first();
			// if($getSalesOrder == null AND $action != "create"){
			// throw new \Exception("sales orders status not is draft");
			// }

			$locationTransferDetailId = addslashes($this->request->getPost("locationTransferDetailId"));

			if ($action == "create") {

				// delete table `locationTransfersDetailsTemp`
				$deleteTemp = $locationTransfersDetailsTempModel->delete($locationTransferDetailId);
				if ($deleteTemp) {
					$returnValue = json_encode(array('status' => "success", "msg" => "Delete Success"));
				} else {
					foreach ($locationTransfersDetailsTempModel->errors() as $error) {
					}
					throw new \Exception($error);
				}
			} else {

				// delete table `locationTransfersDetails`
				$delete = $locationTransfersDetailsModel->delete($locationTransferDetailId);
				if ($delete) {
					$returnValue = json_encode(array('status' => "success", "msg" => "Delete Success"));
				} else {
					foreach ($locationTransfersDetailsModel->errors() as $error) {
					}
					throw new \Exception($error);
				}
			}
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function updateLocationTransferDetails($action = "")
	{
		header('Content-Type: application/json');

		// get model table
		$productsModel						= new \App\Models\ProductsModel();
		$locationTransfersDetailsModel		= new \App\Models\LocationTransfersDetailsModel();
		$locationTransfersDetailsTempModel	= new \App\Models\LocationTransfersDetailsTempModel();

		try {
			// throw new \Exception("Action Empty." . $action);
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			if (empty($action)) {
				throw new \Exception("Action Empty.");
			}

			if ($this->request->getPostGet('transferQuantity') <= 0) {
				throw new \Exception("Transactions cannot be created with Zero Quantity");
			}

			// $getSalesOrder	= $salesOrdersModel->where(array('salesOrderId' => $action, 'statusId' => \SALES_ORDER_STATUS::DRAFT))->first();
			// if($getSalesOrder == null AND $action != "create"){
			// throw new \Exception("sales orders status not is draft");
			// }

			$this->validation->setRules([
				"locationTransferDetailId"	=> ["label" => "*locationTransferDetailId*", "rules" => "required|min_length[1]|max_length[20]"],
				"productId"					=> ["label" => "*Product ID*", "rules" => "required|min_length[1]|max_length[10]"],
				"sourceStock"				=> ["label" => "*Source Stock*", "rules" => "required|min_length[1]|max_length[10]"],
				"destinationStock"			=> ["label" => "*Destination Stock*", "rules" => "required|min_length[1]|max_length[10]"],
				"transferQuantity"			=> ["label" => "*Transfer Quantity*", "rules" => "required|min_length[1]|max_length[10]"],
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

			if ($this->request->getPostGet('sourceStock') < $this->request->getPostGet('transferQuantity')) {
				throw new \Exception("You do not have sufficient stock to create out-transactions for the products.");
			}

			$locationTransferDetailId = addslashes($this->request->getPost("locationTransferDetailId"));

			//update locationTransfersDetailsTemp
			$paramUpdate = array(
				'productId'			=> $getProduct->productId,
				'productNumber'		=> $getProduct->productNumber,
				'productName'		=> $getProduct->productName,
				'productType'		=> $getProduct->productType,
				'priceCost'			=> $getProduct->priceCost,
				'priceSell'			=> $getProduct->priceSell,
				'sourceStock'		=> $this->request->getPost("sourceStock"),
				'destinationStock'	=> $this->request->getPost("destinationStock"),
				'transferQuantity'	=> $this->request->getPost("transferQuantity"),
				'length'			=> $getProduct->length,
				'width'				=> $getProduct->width,
				'height'			=> $getProduct->height,
				'weight'			=> $getProduct->weight,
				'unit'				=> $getProduct->unit,
				'updateBy'			=> session()->get("userId"),
			);

			$locationTransfersDetailsTempModel->where("locationTransferDetailId", $locationTransferDetailId);
			$locationTransfersDetailsTempModel->set($paramUpdate);
			$locationTransfersDetailsTempModel->update();

			$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}
}
