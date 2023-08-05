<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Packages extends BaseController
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
		return view('packages/packages');
	}

	public function getJson()
	{
		// header('Content-Type: application/json');

		// get model table
		$packagesModel = new \App\Models\PackagesModel();

		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'userId';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'asc';
		$offset = ($page - 1) * $rows;

		$result = array();
		$result['total'] = $packagesModel->getCount();
		$row = array();

		// $packagesModel->where('statusId', 1);
		// $packagesModel->limit($rows,$offset);
		// $packagesModel->orderBy($sort,$order);
		$criteria = $packagesModel->getAll();

		foreach ($criteria as $data) {
			if ($data->statusId == \USERS::ACTIVE) {
				$status = "<div class='circle green'></div> Active";
			} else if ($data->statusId == \USERS::DISABLED) {
				$status = "<div class='circle red'></div> Disable";
			}

			$row[] = array(
				'userId'			=> $data->userId,
				'userName'			=> $data->userName,
				'fullName'			=> $data->fullName,
				'email'				=> $data->email,
				'password'			=> $data->password,
				'changePassword'	=> $data->changePassword,
				'groupId'			=> $data->groupId,
				'groupName'			=> $data->groupName,
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

	public function getJsonDetailsTemp()
	{
		// helper
		Helper('web');

		// get model table
		$packagesModel		= new \App\Models\PackagesModel();
		$packagesDetailsTempModel = new \App\Models\PackagesDetailsTempModel();
		$packagesDetailsModel = new \App\Models\PackagesDetailsModel();

		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'inputDate';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'asc';
		$offset = ($page - 1) * $rows;

		$result = array();
		$result['total'] = $packagesDetailsTempModel->getCount();
		$row = array();

		$criteria = $packagesDetailsTempModel->getAll();

		foreach ($criteria as $data) {
			// if ($data->statusId == \USERS::ACTIVE) {
			// 	$status = "<div class='circle green'></div> Active";
			// } else if ($data->statusId == \USERS::DISABLED) {
			// 	$status = "<div class='circle red'></div> Disable";
			// }

			$row[] = array(
				'packageDetailId'		=> $data->packageDetailId,
				// 'salesOrderNumber'		=> $data->autoSalesOrderNumber(),
				'salesOrderDetailId'	=> $data->salesOrderDetailId,
				'productId'				=> $data->productId,
				'productNumber'			=> $data->productNumber,
				'productName'			=> $data->productName,
				'ordered'				=> $data->ordered,
				'quantityToPack'		=> $data->quantityToPack,
				// 'quantity'				=> $data->quantity,
				// 'amount'				=> \FormatCurrency($data->amount),
				// 'unit'					=> $data->unit,
			);
		}
		$result = array_merge($result, array('rows' => $row));
		return json_encode($result);
	}

	public function deleteDetailsTempAll()
	{
		$packagesDetailsTempModel = new \App\Models\PackagesDetailsTempModel();
		$packagesDetailsTempModel->where('inputBy', session()->get('userId'))->delete();
	}

	public function updatePackages()
	{
		header('Content-Type: application/json');

		// get model table
		$packagesModel = new \App\Models\PackagesModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"userName" 	=> ["label" => "*Name*", "rules" => "required|min_length[3]|max_length[255]"],
				"fullName" 	=> ["label" => "*Full Name*", "rules" => "required|min_length[3]|max_length[255]"],
				"email"		=> ["label" => "*Email*", "rules" => "valid_email|min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$userId = addslashes($this->request->getPost("userId"));

			//update packages
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
			if (!empty($this->request->getPost("passwordChange"))) {
				$paramUpdate['password'] = $this->request->getPost("passwordChange");
			}

			$packagesModel->where("userId", $userId);
			$packagesModel->set($paramUpdate);
			$packagesModel->update();

			$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function createPackages()
	{
		header('Content-Type: application/json');

		// get model table
		$packagesModel = new \App\Models\PackagesModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"userName" 	=> ["label" => "*Name*", "rules" => "required|min_length[3]|max_length[255]"],
				"fullName" 	=> ["label" => "*Full Name*", "rules" => "required|min_length[3]|max_length[255]"],
				"email" 	=> ["label" => "*Email*", "rules" => "valid_email|min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			// $userId = addslashes($this->request->getPost("userId"));

			// insert packages
			$paramInsert = array(
				// 'userId'			=> $packagesModel->autoPackagesId('userId'),
				'userName'			=> $this->request->getPost("userName"),
				'fullName'			=> $this->request->getPost("fullName"),
				'email'				=> $this->request->getPost("email"),
				'password'			=> $this->request->getPost("passwordChange"),
				'statusId'			=> $this->request->getPost("statusId"),
				'groupId'			=> $this->request->getPost("groupId"),
				'changePassword'	=> $this->request->getPost("changePassword"),
				'inputBy'			=> session()->get("userId"),
			);

			$insert = $packagesModel->insert($paramInsert);
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

	public function deletePackages()
	{
		header('Content-Type: application/json');

		// get model table
		$packagesModel = new \App\Models\PackagesModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
				// throw new \Exception(($this->request->getJson("userId")));
			}

			$userId = addslashes($this->request->getPost("userId"));

			// delete packages
			$delete = $packagesModel->delete($userId);
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

	public function formPackages($action = "")
	{
		// get model table
		$packagesModel = new \App\Models\PackagesModel();

		if ($action == "create") {
			// clear table packages_details_temp
			$this->deleteDetailsTempAll();

			$data['urlDatagrid'] = base_url('packages/getJsonDetailsTemp');
		} else {
			// $data['urlDatagrid'] = base_url('salesorders/getJsonDetails?salesOrderId=' . $action);
		}

		$data['action']	= $action;
		$data['packageNumber']	= $packagesModel->autoPackageNumber();
		return view("packages/addPackages", $data);
	}

	public function formPackagesDetails($action = "")
	{
		// get model table
		// $packagesModel = new \App\Models\PackagesModel();

		$data['salesOrderId'] = $this->request->getGet('salesOrderId');
		return view("packages/addPackagesDetails", $data);
	}

	public function createPackagesDetails($action = "")
	{
		header('Content-Type: application/json');

		// get model table
		$packagesDetailsTempModel	= new \App\Models\PackagesDetailsTempModel();
		$productsModel	= new \App\Models\ProductsModel();
		$salesOrdersModel	= new \App\Models\SalesOrdersModel();
		$salesOrdersDetailsModel	= new \App\Models\SalesOrdersDetailsModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"productId"			=> ["label" => "*Product ID*", "rules" => "required|min_length[3]|max_length[255]"],
				"salesOrderDetailId"		=> ["label" => "*Sales Order Detail ID*", "rules" => "required|min_length[3]|max_length[255]"],
				"quantityToPack" 	=> ["label" => "*Quantity To Pack*", "rules" => "required|min_length[1]|max_length[255]"],
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

			if ($this->request->getPost("quantityToPack") <= 0) {
				throw new \Exception("Quantity To Pack 0 not valid");
			}

			if ($this->request->getPost("quantityToPack") > $getSalesOrdersDetailsModel->quantity) {
				throw new \Exception("Over Quantity To Pack");
			}

			// $userId = addslashes($this->request->getPost("userId"));

			// insert packages
			$paramInsert = array(
				'productId'			=> $this->request->getPost("productId"),
				'ordered'			=> $getSalesOrdersDetailsModel->quantity,
				'salesOrderDetailId' => $getSalesOrdersDetailsModel->salesOrderDetailId,
				// 'salesOrderId'		=> $this->request->getPost("salesOrderId"),
				'quantityToPack'	=> $this->request->getPost("quantityToPack"),
				'statusId'			=> 1,
				'inputBy'			=> session()->get("userId"),
			);

			$insert = $packagesDetailsTempModel->insert($paramInsert);
			if ($insert) {
				$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
			} else {
				foreach ($packagesDetailsTempModel->errors() as $error) {
				}
				throw new \Exception($error);
			}
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function deletePackagesDetails($action = "")
	{
		header('Content-Type: application/json');

		// get model table
		$packagesModel				= new \App\Models\PackagesModel();
		$packagesDetailsModel		= new \App\Models\PackagesDetailsModel();
		$packagesDetailsTempModel	= new \App\Models\PackagesDetailsTempModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
				// throw new \Exception(($this->request->getJson("userId")));
			}

			if (empty($action)) {
				throw new \Exception("Action Empty.");
			}

			$packageDetailId = addslashes($this->request->getPost("packageDetailId"));

			if ($action == "create") {

				// delete table `packagesDetailsTemp`
				$deleteTemp = $packagesDetailsTempModel->delete($packageDetailId);
				if ($deleteTemp) {
					$returnValue = json_encode(array('status' => "success", "msg" => "Delete Success"));
				} else {
					foreach ($packagesDetailsTempModel->errors() as $error) {
					}
					throw new \Exception($error);
				}
			} else {

				// delete table `salesOrdersDetails`
				$delete = $packagesDetailsModel->delete($packageDetailId);
				if ($delete) {
					$returnValue = json_encode(array('status' => "success", "msg" => "Delete Success"));
				} else {
					foreach ($packagesDetailsModel->errors() as $error) {
					}
					throw new \Exception($error);
				}
			}
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function updatePackagesDetails($action = "")
	{
		header('Content-Type: application/json');

		// get model table
		$packagesDetailsTempModel		= new \App\Models\PackagesDetailsTempModel();
		$salesOrdersModel				= new \App\Models\SalesOrdersModel();
		$salesOrdersDetailsModel 		= new \App\Models\SalesOrdersDetailsModel();
		$salesOrdersDetailsTempModel	= new \App\Models\SalesOrdersDetailsTempModel();
		$productsModel					= new \App\Models\ProductsModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			if (empty($action)) {
				throw new \Exception("Action Empty.");
			}

			$this->validation->setRules([
				"productId"				=> ["label" => "*Product ID*", "rules" => "required|min_length[3]|max_length[255]"],
				"salesOrderDetailId"	=> ["label" => "*Sales Order Detail ID*", "rules" => "required|min_length[3]|max_length[255]"],
				"quantityToPack"		=> ["label" => "*Quantity To Pack*", "rules" => "required|min_length[1]|max_length[255]"],
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

			if ($this->request->getPost("quantityToPack") <= 0) {
				throw new \Exception("Quantity To Pack 0 not valid");
			}

			if ($this->request->getPost("quantityToPack") > $getSalesOrdersDetailsModel->quantity) {
				throw new \Exception("Over Quantity To Pack");
			}

			$packageDetailId = addslashes($this->request->getPost("packageDetailId"));

			//update `packagesDetailsTemp`
			// insert packages
			$paramUpdate = array(
				'productId'			=> $this->request->getPost("productId"),
				'ordered'			=> $getSalesOrdersDetailsModel->quantity,
				'salesOrderDetailId'	=> $getSalesOrdersDetailsModel->salesOrderDetailId,
				// 'salesOrderId'		=> $this->request->getPost("salesOrderId"),
				'quantityToPack'	=> $this->request->getPost("quantityToPack"),
				'statusId'			=> 1,
				'inputBy'			=> session()->get("userId"),
			);

			$packagesDetailsTempModel->where("packageDetailId", $packageDetailId);
			$packagesDetailsTempModel->set($paramUpdate);
			$packagesDetailsTempModel->update();

			$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}
}
