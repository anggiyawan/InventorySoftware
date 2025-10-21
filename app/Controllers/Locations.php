<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Locations extends BaseController
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
		return view('locations/locations');
	}

	public function getJson()
	{
		// header('Content-Type: application/json');

		// get model table
		$locationsModel = new \App\Models\LocationsModel();

		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'locationId';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'asc';
		$offset = ($page - 1) * $rows;

		$result = array();
		$result['total'] = $locationsModel->getCount();
		$row = array();

		$criteria = $locationsModel->getAll(array("sort" => $sort, "order" => $order, "offset" => $offset, "rows" => $rows));

		foreach ($criteria as $data) {
			if ($data->statusId == \LOCATION::ACTIVE) {
				$status = "<div class='circle green'></div> Active";
			} else if ($data->statusId == \LOCATION::DISABLED) {
				$status = "<div class='circle red'></div> Disable";
			}

			$row[] = array(
				'locationId'		=> $data->locationId,
				'locationName'		=> $data->locationName,
				'remark'			=> $data->remark,
				'status'			=> $status,
				'statusId'			=> $data->statusId,
				'inputBy'			=> $data->inputBy,
				'inputDate'			=> date('Y-m-d', strtotime($data->inputDate)),
				'updateBy'			=> $data->updateBy,
				'updateDate'		=> date('Y-m-d', strtotime($data->updateDate))
			);
		}
		$result = array_merge($result, array('rows' => $row));
		return json_encode($result);
	}

	public function getJsonLocationProducts()
	{
		// get model table
		$locationStockModel = new \App\Models\LocationStockModel();

		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'productId';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'asc';
		$offset = ($page - 1) * $rows;

		$result = array();
		$result['total'] = $locationStockModel->getCount();
		$row = array();

		$criteria = $locationStockModel->getAll(array("sort" => $sort, "order" => $order, "offset" => $offset, "rows" => $rows));

		foreach ($criteria as $data) {
			if ($data->statusId == \LOCATION::ACTIVE) {
				$status = "<div class='circle green'></div> Active";
			} else if ($data->statusId == \LOCATION::DISABLED) {
				$status = "<div class='circle red'></div> Disable";
			}

			if ($data->stockAcc != 0 or $data->stockPhy != 0) {
				$row[] = array(
					'locationId'		=> $data->locationId,
					'locationName'		=> $data->locationName,
					'productId'			=> $data->productId,
					'productNumber'		=> $data->productNumber,
					'productName'		=> $data->productName,
					'stockAcc'			=> $data->stockAcc,
					'stockPhy'			=> $data->stockPhy,
					'remark'			=> $data->remark,
					'status'			=> $status,
					'statusId'			=> $data->statusId,
					'inputBy'			=> $data->inputBy
				);
			}
		}
		$result = array_merge($result, array('rows' => $row));
		return json_encode($result);
	}

	public function updateLocations()
	{
		header('Content-Type: application/json');

		// get model table
		$locationsModel = new \App\Models\LocationsModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"locationName" 	=> ["label" => "*Location Name*", "rules" => "required|min_length[3]|max_length[255]"],
				"remark" 	=> ["label" => "*Remark*", "rules" => "min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$locationId = addslashes($this->request->getPost("locationId"));

			//update location
			$paramUpdate = array(
				'locationId'		=> $locationId,
				'locationName'		=> $this->request->getPost("locationName"),
				'remark'			=> $this->request->getPost("remark"),
				'statusId'			=> $this->request->getPost("statusId"),
				'updateBy'			=> session()->get("userId"),
			);

			$locationsModel->where("locationId", $locationId);
			$locationsModel->set($paramUpdate);
			$locationsModel->update();

			$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function createLocations()
	{
		header('Content-Type: application/json');

		// get model table
		$locationsModel = new \App\Models\LocationsModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"locationName" 	=> ["label" => "*Location Name*", "rules" => "required|is_unique[locations.locationName]|min_length[3]|max_length[255]"],
				"remark" 	=> ["label" => "*Remark*", "rules" => "min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			// $userId = addslashes($this->request->getPost("userId"));

			// insert location
			$paramInsert = array(
				'locationName'		=> $this->request->getPost("locationName"),
				'remark'			=> $this->request->getPost("remark"),
				'statusId'			=> $this->request->getPost("statusId"),
				'inputBy'			=> session()->get("userId"),
			);

			$insert = $locationsModel->insert($paramInsert);
			if ($insert) {
				$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
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

	public function createAdjustments()
	{
		header('Content-Type: application/json');

		// return json_encode(array('status' => "success", "msg" => "Success"));

		// get model table
		$adjustmentsModel			= new \App\Models\AdjustmentsModel();
		$adjustmentsDetailsModel	= new \App\Models\adjustmentsDetailsModel();
		$locationsModel				= new \App\Models\LocationsModel();
		$locationStockModel			= new \App\Models\LocationStockModel();
		$productsModel				= new \App\Models\ProductsModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"productId"		=> ["label" => "*Product ID*", "rules" => "required|min_length[3]|max_length[255]"],
				"locationId"	=> ["label" => "*Location ID*", "rules" => "required|min_length[6]|max_length[11]"],
				"physicalQuantity"	=> ["label" => "*Physical New Quantity*", "rules" => "required|integer|max_length[11]"],
				"remarkAdjustment"	=> ["label" => "*Remark*", "rules" => "max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$getLocations = $locationsModel->where(array('locationId' => $this->request->getPost("locationId"), 'statusId' => 1))->first();
			if ($getLocations == null) {
				throw new \Exception("Location not valid");
			}

			$productId = addslashes($this->request->getPost("productId"));

			$getProducts = $productsModel->where(array('productId' => $productId))->first();
			if ($getProducts == null) {
				throw new \Exception("Product not valid");
			}

			$getStock = $locationStockModel->getStockPhy($this->request->getPost("locationId"), $productId);
			$adjustmentQuantity = $this->request->getPost("physicalQuantity") - $getStock;

			$this->db->transBegin();

			// insert location
			$paramInsert = array(
				'reffNumber'		=> $adjustmentsModel->autoAdjustmentNumber(),
				'adjustmentDate'	=> date('Y-m-d H:i:s'),
				'locationId'		=> $this->request->getPost("locationId"),
				'locationName'		=> $getLocations->locationName,
				'remark'			=> $this->request->getPost("remarkAdjustment"),
				'statusId'			=> 1,
				'inputBy'			=> session()->get("userId"),
			);

			$adjustmentsModel->insert($paramInsert);

			$paramAdjustmentDetailsTemp = array(
				'adjustmentId'		=> $adjustmentsModel->getInsertID(),
				'productId'			=> $productId,
				'productNumber'		=> $getProducts->productNumber,
				'productName'		=> $getProducts->productName,
				'AvailableQuantity'	=> $getStock,
				'NewQuantity'		=> $this->request->getPost("physicalQuantity"),
				'AdjustedQuantity'	=> $adjustmentQuantity,
				'remark'			=> $this->request->getPost("remarkAdjustment"),
				'statusId'			=> 1,
				'inputBy'			=> session()->get("userId"),
			);
			$adjustmentsDetailsModel->insert($paramAdjustmentDetailsTemp);

			// Adjustment
			$locationStockModel->where("productId", $productId);
			$locationStockModel->where("locationId", $this->request->getPost("locationId"));
			$locationStockModel->set('stockAcc', 'stockAcc +' . $adjustmentQuantity, false);
			$locationStockModel->set('stockPhy', $this->request->getPost("physicalQuantity"));
			$locationStockModel->update();
			// Adjustment EOF

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

	public function deleteLocations()
	{
		header('Content-Type: application/json');

		// get model table
		$locationsModel = new \App\Models\LocationsModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
				// throw new \Exception(($this->request->getJson("locationId")));
			}

			$locationId = addslashes($this->request->getPost("locationId"));

			// delete location
			$delete = $locationsModel->delete($locationId);
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

	public function formLocations()
	{
		return view("locations/addLocations");
	}

	public function formAdjustments()
	{
		return view("locations/addAdjustments");
	}
}
