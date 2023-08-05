<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Users extends BaseController
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
	
	public function grid()
    {
        $grid = json_encode($this->request->getPost("grid"));
		log_message('error', $grid);
		
		$fp = fopen('data.html', 'w');
		fwrite($fp, stripslashes($grid));
		fclose($fp);

		$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
		echo $returnValue;
    }
	
	public function manage()
    {
        return view('users/users');
    }
	
	public function getJson()
    {
		// header('Content-Type: application/json');
		
		// get model table
		$usersModel = new \App\Models\UsersModel();

        $page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'userId';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'desc';
		$offset = ($page-1) * $rows;
		
		$result = array();
		$result['total'] = $usersModel->getCount();
		$row = array();
		
		$criteria = $usersModel->getAll(array("sort" => $sort, "order" => $order, "offset" => $offset, "rows" => $rows));
		
		foreach($criteria as $data)
		{	
			if ( $data->statusId == \USERS::ACTIVE ) {
		        $status = "<img src='" . base_url('assets/css/icons/st_green.gif') . "'> Active";
			}
		    else if ( $data->statusId == \USERS::DISABLED ) {
		        $status = "<img src='" . base_url('assets/css/icons/st_red.gif') . "'> Disable";
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
		// $columns = array();
		$columns = array($this->readColumn());
		
		$result=array_merge($result,array('rows'=>$row, 'columns'=> $columns));
		return stripslashes(json_encode($result, JSON_UNESCAPED_SLASHES));
    }
	
	private function readColumn()
	{
		$columns[] = array(
					'field' => 'userId',
					'title' => 'User ID',
					'sortable' => true,
					'width' => '80'
				);
		$columns[] = array(
					'field' => 'userName',
					'title' => 'User Name',
					'sortable' => true,
					'width' => '80'
				);
		$columns[] = array(
					'field' => 'fullName',
					'title' => 'full Name',
					'sortable' => true,
					'width' => '80'
				);
				
		// $arrayColumn[] = $columns;
		// return $arrayColumn;
		$arrayColumn = file(base_url('data.html'));
		return json_decode(trim((($arrayColumn[0])), "\""));
	}
	
	public function updateUsers()
    {
		header('Content-Type: application/json');
		
		// get model table
		$usersModel = new \App\Models\UsersModel();
		
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
			
			//update users
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
			
			$usersModel->where("userId", $userId);
			$usersModel->set($paramUpdate);
			$usersModel->update();
			
			$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
		}
		catch(\Exception $ex)
		{
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}
		
		echo $returnValue;
    }
	
	public function createUsers()
    {
		header('Content-Type: application/json');
		
		// get model table
		$usersModel = new \App\Models\UsersModel();
		
		try
		{
			if(empty( $this->request->getPostGet() )) {
				throw new \Exception("Data Empty.");
			}
			
			$this->validation->setRules([
                "userName" 	=> ["label" => "*Name*", "rules" => "required|min_length[3]|max_length[255]"],
                "fullName" 	=> ["label" => "*Full Name*", "rules" => "required|min_length[3]|max_length[255]"],
				"email" 	=> ["label" => "*Email*", "rules" => "valid_email|min_length[3]|max_length[255]"],
            ]);
			
			if(!$this->validation->withRequest($this->request)->run()){
				foreach ($this->validation->getErrors() as $error) {}
				throw new \Exception($error);
			}
			
			// $userId = addslashes($this->request->getPost("userId"));
			
			// insert users
			$paramInsert = array(
				// 'userId'			=> $usersModel->autoUsersId('userId'),
				'userName'			=> $this->request->getPost("userName"),
				'fullName'			=> $this->request->getPost("fullName"),
				'email'				=> $this->request->getPost("email"),
				'password'			=> $this->request->getPost("passwordChange"),
				'statusId'			=> $this->request->getPost("statusId"),
				'groupId'			=> $this->request->getPost("groupId"),
				'changePassword'	=> $this->request->getPost("changePassword"),
				'inputBy'			=> session()->get("userId"),
			);
			
			$insert = $usersModel->insert($paramInsert);
			if($insert) {
				$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
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
	
	public function deleteUsers()
    {
		header('Content-Type: application/json');
		
		// get model table
		$usersModel = new \App\Models\UsersModel();
		
		try
		{
			if(empty( $this->request->getPostGet() )) {
				throw new \Exception("Data Empty.");
				// throw new \Exception(($this->request->getJson("userId")));
			}
			
			$userId = addslashes($this->request->getPost("userId"));
			
			// delete users
			$delete = $usersModel->delete($userId);
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
	
	public function formUsers()
    {
		return view("users/addUsers");
	}
	
}
