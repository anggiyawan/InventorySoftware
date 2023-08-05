<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Representatives extends BaseController
{
	public function __construct()
	{
		// $this->db		= \Config\Database::connect();
		$this->request	= \Config\Services::request();
		$this->session	= \Config\Services::session();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{
		//
	}

	public function manage()
	{
		return view('representatives/representatives');
	}

	public function getJson()
	{
		// header('Content-Type: application/json');

		// get model table
		$representativesModel = new \App\Models\RepresentativesModel();

		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'representativeId';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'desc';
		$offset = ($page - 1) * $rows;

		$result = array();
		$result['total'] = $representativesModel->getCount();
		$row = array();

		$criteria = $representativesModel->getAll(array("sort" => $sort, "order" => $order, "offset" => $offset, "rows" => $rows));

		foreach ($criteria as $data) {
			if ($data->statusId == \REPRESENTATIVES::ENABLED) {
				$status = "<div class='circle green'></div> Enable";
			} else if ($data->statusId == \REPRESENTATIVES::DISABLED) {
				$status = "<div class='circle red'></div> Disable";
			}

			$row[] = array(
				'representativeId'	=> $data->representativeId,
				'representative'	=> $data->representative,
				'description'		=> $data->description,
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

	public function updateRepresentatives()
	{
		header('Content-Type: application/json');

		// get model table
		$representativesModel = new \App\Models\RepresentativesModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"representativeId"	=> ["label" => "*representativeId*", "rules" => "required|min_length[3]|max_length[255]"],
				"representative"	=> ["label" => "*representative*", "rules" => "required|min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$representativeId = addslashes($this->request->getPost("representativeId"));

			//update representatives
			$paramUpdate = array(
				'representativeId'	=> $representativeId,
				'representative'	=> $this->request->getPost("representative"),
				'description'		=> $this->request->getPost("description"),
				'statusId'			=> $this->request->getPost("statusId"),
				'updateBy'			=> session()->get("userId"),
			);

			$representativesModel->where("representativeId", $representativeId);
			$representativesModel->set($paramUpdate);
			$representativesModel->update();

			$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function createRepresentatives()
	{
		header('Content-Type: application/json');

		// get model table
		$representativesModel = new \App\Models\RepresentativesModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"representative"	=> ["label" => "*representative*", "rules" => "required|min_length[3]|max_length[255]"],
				"description"		=> ["label" => "*Description*", "rules" => "required|min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			// $groupId = addslashes($this->request->getPost("groupId"));

			//insert representatives
			$paramInsert = array(
				'representative'	=> $this->request->getPost("representative"),
				'description'		=> $this->request->getPost("description"),
				'statusId'			=> $this->request->getPost("statusId"),
				'inputBy'			=> session()->get("userId"),
			);

			$insert = $representativesModel->insert($paramInsert);
			if ($insert) {
				$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
			} else {
				foreach ($representativesModel->errors() as $error) {
				}
				throw new \Exception($error);
			}
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function deleteRepresentatives()
	{
		header('Content-Type: application/json');

		// get model table
		$representativesModel = new \App\Models\RepresentativesModel();

		try {
			if (empty($this->request->getPostGet())) {
				throw new \Exception("Data Empty.");
			}

			$this->validation->setRules([
				"representativeId"	=> ["label" => "*representativeId*", "rules" => "required|min_length[3]|max_length[255]"],
			]);

			if (!$this->validation->withRequest($this->request)->run()) {
				foreach ($this->validation->getErrors() as $error) {
				}
				throw new \Exception($error);
			}

			$representativeId = addslashes($this->request->getPost("representativeId"));

			// delete representatives
			$delete = $representativesModel->delete($representativeId);
			if ($delete) {
				$returnValue = json_encode(array('status' => "success", "msg" => "Delete Success"));
			} else {
				foreach ($representativesModel->errors() as $error) {
				}
				throw new \Exception($error);
			}
		} catch (\Exception $ex) {
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}

		echo $returnValue;
	}

	public function formRepresentatives()
	{
		return view("representatives/addrepresentatives");
	}

	public function combogridRepresentatives($all = "")
	{
		// header('Content-Type: application/json');
		// get table
		$representativesModel = new \App\Models\RepresentativesModel();
		$row = array();

		if (!empty($all)) {
			$row[] = array(
				'groupId'		=> '',
				'groupName'		=> 'ALL',
				'description'	=> 'ALL'
			);
		}

		$criteria = $representativesModel->where('statusId!=', 0)->findAll();

		foreach ($criteria as $data) {
			$row[] = array(
				'groupId'		=> $data->groupId,
				'groupName'		=> $data->groupName,
				'description'	=> $data->description,
				'inputBy'		=> $data->inputBy,
				'inputDate'		=> date('Y-m-d', strtotime($data->inputDate)),
				'updateBy'		=> $data->updateBy,
				'updateDate'	=> date('Y-m-d', strtotime($data->updateDate))
			);
		}

		return json_encode($row);
	}
}
