<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Groups extends BaseController
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
        return view('groups/groups');
    }
	
	public function getJson()
    {
		// header('Content-Type: application/json');
		
		// get model table
		$groupsModel = new \App\Models\GroupsModel();

        $page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'groupId';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'asc';
		$offset = ($page-1) * $rows;
		
		$result = array();
		$result['total'] = $groupsModel->getCount();
		$row = array();
		
		$criteria = $groupsModel->getAll(array("sort" => $sort, "order" => $order, "offset" => $offset, "rows" => $rows));
		
		foreach($criteria as $data)
		{
			if ( $data->statusId == \GROUPS::ENABLED ) {
		        $status = "<img src='" . base_url('assets/css/icons/st_green.gif') . "'> Enable";
			}
		    else if ( $data->statusId == \GROUPS::DISABLED ) {
		        $status = "<img src='" . base_url('assets/css/icons/st_red.gif') . "'> Disable";
			}
			
			$row[] = array(
				'groupId'			=> $data->groupId,
				'groupName'			=> $data->groupName,
				'description'		=> $data->description,
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
	
	public function updateGroups()
    {
		header('Content-Type: application/json');
		
		// get model table
		$groupsModel = new \App\Models\GroupsModel();
		
		try
		{
			if(empty( $this->request->getPostGet() )) {
				throw new \Exception("Data Empty.");
			}
			
			$this->validation->setRules([
                "groupName" 	=> ["label" => "*Name*", "rules" => "required|min_length[3]|max_length[255]"],
                "description" 	=> ["label" => "*Full Name*", "rules" => "required|min_length[3]|max_length[255]"],
            ]);
			
			if(!$this->validation->withRequest($this->request)->run()){
				foreach ($this->validation->getErrors() as $error) {}
				throw new \Exception($error);
			}
			
			$groupId = addslashes($this->request->getPost("groupId"));
			
			//update groups
			$paramUpdate = array(
				'groupId'			=> $groupId,
				'groupName'			=> $this->request->getPost("groupName"),
				'description'		=> $this->request->getPost("description"),
				'statusId'			=> $this->request->getPost("statusId"),
				'updateBy'			=> session()->get("userId"),
			);
			
			$groupsModel->where("groupId", $groupId);
			$groupsModel->set($paramUpdate);
			$groupsModel->update();
			
			$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
		}
		catch(\Exception $ex)
		{
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}
		
		echo $returnValue;
    }
	
	public function createGroups()
    {
		header('Content-Type: application/json');
		
		// get model table
		$groupsModel = new \App\Models\GroupsModel();
		
		try
		{
			if(empty( $this->request->getPostGet() )) {
				throw new \Exception("Data Empty.");
			}
			
			$this->validation->setRules([
                "groupName" 	=> ["label" => "*Name*", "rules" => "required|min_length[3]|max_length[255]"],
                "description" 	=> ["label" => "*Full Name*", "rules" => "required|min_length[3]|max_length[255]"],
            ]);
			
			if(!$this->validation->withRequest($this->request)->run()){
				foreach ($this->validation->getErrors() as $error) {}
				throw new \Exception($error);
			}
			
			// $groupId = addslashes($this->request->getPost("groupId"));
			
			//insert groups
			$paramInsert = array(
				'groupName'			=> $this->request->getPost("groupName"),
				'description'		=> $this->request->getPost("description"),
				'statusId'			=> $this->request->getPost("statusId"),
				'inputBy'			=> session()->get("userId"),
			);
			
			$insert = $groupsModel->insert($paramInsert);
			if($insert) {
				$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
			} else {
					foreach ($groupsModel->errors() as $error) {}
					throw new \Exception($error);
			}
		}
		catch(\Exception $ex)
		{
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}
		
		echo $returnValue;
    }
	
	public function deleteGroups()
    {
		header('Content-Type: application/json');
		
		// get model table
		$groupsModel = new \App\Models\GroupsModel();
		
		try
		{
			if(empty( $this->request->getPostGet() )) {
				throw new \Exception("Data Empty.");
			}
			
			$groupId = addslashes($this->request->getPost("groupId"));
			
			// delete groups
			$delete = $groupsModel->delete($groupId);
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
	
	public function formGroups()
    {
		return view("groups/addgroups");
	}
	
	public function combogridGroups($all = "")
	{
		// header('Content-Type: application/json');
		// get table
		$groupsModel = new \App\Models\GroupsModel();
		$row = array();
		
		if ( !empty($all) ) {
			$row[] = array(
					'groupId'		=> '',
					'groupName'		=> 'ALL',
					'description'	=> 'ALL'
				);
		}
		
		$criteria = $groupsModel->where('statusId!=', 0)->findAll();
		
		foreach($criteria as $data)
		{	
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
