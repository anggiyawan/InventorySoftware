<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Shipments extends BaseController
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
		return view('shipments/shipments');
	}

	public function getJson()
	{
		// header('Content-Type: application/json');

		// get model table
		$shipmentsModel = new \App\Models\ShipmentsModel();

		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'userId';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'asc';
		$offset = ($page - 1) * $rows;

		$result = array();
		$result['total'] = $shipmentsModel->getCount();
		$row = array();

		// $shipmentsModel->where('statusId', 1);
		// $shipmentsModel->limit($rows,$offset);
		// $shipmentsModel->orderBy($sort,$order);
		$criteria = $shipmentsModel->getAll();

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

	public function updateShipments()
	{
		header('Content-Type: application/json');

		// get model table
		$shipmentsModel = new \App\Models\ShipmentsModel();

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

			//update shipments
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

			$shipmentsModel->where("userId", $userId);
			$shipmentsModel->set($paramUpdate);
			$shipmentsModel->update();

			$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function createShipments()
	{
		header('Content-Type: application/json');

		// get model table
		$shipmentsModel = new \App\Models\ShipmentsModel();

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

			// insert shipments
			$paramInsert = array(
				// 'userId'			=> $shipmentsModel->autoShipmentsId('userId'),
				'userName'			=> $this->request->getPost("userName"),
				'fullName'			=> $this->request->getPost("fullName"),
				'email'				=> $this->request->getPost("email"),
				'password'			=> $this->request->getPost("passwordChange"),
				'statusId'			=> $this->request->getPost("statusId"),
				'groupId'			=> $this->request->getPost("groupId"),
				'changePassword'	=> $this->request->getPost("changePassword"),
				'inputBy'			=> session()->get("userId"),
			);

			$insert = $shipmentsModel->insert($paramInsert);
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

	public function deleteShipments()
	{
		header('Content-Type: application/json');

		// get model table
		$shipmentsModel = new \App\Models\ShipmentsModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
				// throw new \Exception(($this->request->getJson("userId")));
			}

			$userId = addslashes($this->request->getPost("userId"));

			// delete shipments
			$delete = $shipmentsModel->delete($userId);
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

	public function formShipments()
	{
		return view("shipments/addShipments");
	}
}
