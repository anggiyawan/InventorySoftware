<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Perm extends BaseController
{
	public function __construct()
	{
		$this->db		= \Config\Database::connect();
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
        return view('perm/perm');
    }
	
	public function getJson($group_id)
	{
		// model
		$menuModel = new \App\Models\MenuModel();
		
		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'menuOrder';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'asc';
		$offset = ($page-1) * $rows;
		
		$result = array();
		$row = array();
		
		$criteria = $menuModel->where( array("menuPid" => 100001, "statusId" => 1) )->orderBy($sort, $order)->findAll();
		// var_dump($criteria);
		foreach($criteria as $data)
		{	
			//menuPid = 1
			$view_ 		= $this->_checked($data->menuId, 'view', $group_id);
			
			$spasi_ = str_repeat("<font color='white'>.</font>", $data->menuLevel);
			$row[] = array(
				'menuId'	=> $data->menuId,
				'groupId'	=> $group_id,
				'menu'		=> $spasi_ . " <img width='8px' src='" . base_url("assets/css/icons/arrow.png") . "'> " . $data->title,
				'view'		=> "<input type='checkbox' name='view' onclick='checkClick(" . $data->menuId . ", \"view\", \"" . $group_id . "\")' id='view" . $data->menuId . "' " . $view_ . ">",
					'created'	=> "",
					'updated'	=> "",
					'cancelled'	=> "",
					'deleted'	=> "",
					'printed'		=> "",
					'downloaded'=> "",
					// 'uploaded'	=> "",
					'closed'	=> "",
					'verified'	=> "",
				);
			
			//menuPid != 1
			$menuChild = $menuModel->where( array("menuPid" => $data->menuId, "statusId" => 1) )->orderBy($sort, $order)->findAll();
			foreach($menuChild as $menu)
			{
				$spasi = str_repeat("<font color='white'>..</font>", $menu->menuLevel);
					
				$view 		= $this->_checked($menu->menuId, 'view', $group_id);
				$created 	= $this->_checked($menu->menuId, 'created', $group_id);
				$updated 	= $this->_checked($menu->menuId, 'updated', $group_id);
				$cancelled 	= $this->_checked($menu->menuId, 'cancelled', $group_id);
				$deleted 	= $this->_checked($menu->menuId, 'deleted', $group_id);
				$printed	= $this->_checked($menu->menuId, 'printed', $group_id);
				$downloaded	= $this->_checked($menu->menuId, 'downloaded', $group_id);
				// $uploaded	= $this->_checked($menu->menuId, 'uploaded', $group_id);
				$closed		= $this->_checked($menu->menuId, 'closed', $group_id);
				$verified	= $this->_checked($menu->menuId, 'verified', $group_id);
				
				$row[] = array(
					'menuId'	=> $menu->menuId,
					'url'		=> $menu->url,
					'groupId'	=> $group_id,
					'menu'		=> $spasi . " <img width='8px' src='" . base_url("assets/css/icons/arrow.png") . "'> " . strtoupper($menu->title),
					'view'		=> (!$menu->view) ? "" : "<input type='checkbox' name='view' 	 onclick='checkClick(" . $menu->menuId . ", \"view\", \"" . $group_id . "\")' id='view" . $menu->menuId . "' " . $view . ">",
					'created'	=> (!$menu->created) ? "" : "<input type='checkbox' name='created' onclick='checkClick(" . $menu->menuId . ", \"created\", \"" . $group_id . "\")' id='created" . $menu->menuId . "' " . $created . ">",
					'updated'	=> (!$menu->updated) ? "" : "<input type='checkbox' name='updated' onclick='checkClick(" . $menu->menuId . ", \"updated\", \"" . $group_id . "\")' id='updated" . $menu->menuId . "' " . $updated . ">",
					'cancelled'	=> (!$menu->cancelled) ? "" : "<input type='checkbox' name='cancelled' onclick='checkClick(" . $menu->menuId . ", \"cancelled\", \"" . $group_id . "\")' id='cancelled" . $menu->menuId . "' " . $cancelled . ">",
					'deleted'	=> (!$menu->deleted) ? "" : "<input type='checkbox' name='deleted' onclick='checkClick(" . $menu->menuId . ", \"deleted\", \"" . $group_id . "\")' id='deleted" . $menu->menuId . "' " . $deleted . ">",
					'printed'	=> (!$menu->printed) ? "" : "<input type='checkbox' name='printed' onclick='checkClick(" . $menu->menuId . ", \"printed\", \"" . $group_id . "\")' id='printed" . $menu->menuId . "' " . $printed . ">",
					'downloaded'=> (!$menu->downloaded) ? "" : "<input type='checkbox' name='downloaded' onclick='checkClick(" . $menu->menuId . ", \"downloaded\", \"" . $group_id . "\")' id='downloaded" . $menu->menuId . "' " . $downloaded . ">",
					// 'uploaded'	=> (!$menu->uploaded) ? "" : "<input type='checkbox' name='uploaded' onclick='checkClick(" . $menu->menuId . ", \"uploaded\", \"" . $group_id . "\")' id='uploaded" . $menu->menuId . "' " . $uploaded . ">",
					'closed'	=> (!$menu->closed) ? "" : "<input type='checkbox' name='closed' onclick='checkClick(" . $menu->menuId . ", \"closed\", \"" . $group_id . "\")' id='closed" . $menu->menuId . "' " . $closed . ">",
					'verified'	=> (!$menu->verified) ? "" : "<input type='checkbox' name='verified' onclick='checkClick(" . $menu->menuId . ", \"verified\", \"" . $group_id . "\")' id='verified" . $menu->menuId . "' " . $verified . ">",
				);
			}
			
		}
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	public function updateId($param)
	{
	
		// model
		$groupsRolesModel = new \App\Models\GroupsRolesModel();
		
		//echo $val[0]; // menuId
		//echo $val[1]; // name 'view', 'create', 'update', 'delete'
		//echo $val[2]; // value checkbox
		//echo $val[3]; // value groupId
		$val =  explode("-", $param);
		$groupId = $val[3];
		
		if (empty($groupId)) {
			exit();
		}
		
		$checkMenu = $groupsRolesModel->checkMenuId($val[0], $groupId);
		
		if( $checkMenu == 1 ) {
			$groupsRolesModel->set($val[1], $val[2]); //value that used to update column  
			$groupsRolesModel->where(array('menuId' => $val[0], 'groupId' => $groupId)); //which row want to upgrade  
			$groupsRolesModel->update();
		} else {
			// $sql = "INSERT INTO groups_roles(groupId, menu_id, " . $val[1] . ") VALUES ('" . $groupId . "', '" . $val[0] . "', '" . $val[2] . "')";
			// $query = $this->db->query($sql);
			
			// Insert users
			$paramInsert = array(
				'groupId'	=> $groupId,
				'menuId'	=> $val[0],
				$val[1]		=> $val[2]
			);
			
			$groupsRolesModel->insert($paramInsert);
		}
		
	}
	
	public function copyGroups()
	{
		header('Content-Type: application/json');

			try
			{
				$groupFrom	= $this->request->getPost('groupFrom');
				$groupTo	= $this->request->getPost('groupTo');
				
				$sqlDelete = "DELETE FROM groupsRoles WHERE groupId={$groupTo}";
				$GetDelete = $this->db->query($sqlDelete);
		
				$sqlUpdate = "INSERT INTO groupsRoles (`groupId`, `menuId`, `view`, `created`, `updated`, `cancelled`, `deleted`, `printed`, `downloaded`, `closed`, `verified`)
				SELECT {$groupTo}, `menuId`, `view`, `created`, `updated`, `cancelled`, `deleted`, `printed`, `downloaded`, `closed`, `verified` FROM groupsRoles WHERE groupId={$groupFrom}";
				$GetSerial = $this->db->query($sqlUpdate);
				if ($GetSerial){	
					$returnValue = json_encode(array('status' => "success", 'message'=> 'Success'));
				} else {
					$returnValue = json_encode(array('status' => "01", 'message'=>'Failed To Save'));
				}					
				
			}
			
			catch(Exception $ex)
			{
				$data = array('status' => "failed", "message" => $ex->getMessage());
				echo json_encode($data);
			}
			
			echo $returnValue;
	}
	
	private function _checked($menuId, $field, $groupId) {
		
		// model
		$groupsRolesModel = new \App\Models\GroupsRolesModel();

		$data = $groupsRolesModel->where( array("groupId" => $groupId, "menuId" => $menuId) )->findAll();
		foreach ( $data as $roles ) {
			if ( $roles->$field == 1 ) { return 'checked'; } else { return '0'; }
		}
		
	}
	
}
