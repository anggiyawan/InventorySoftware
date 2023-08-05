<?php

namespace App\Controllers;
use App\Libraries\Perm; // Import library

class Home extends BaseController
{
	public function __construct()
	{
		$this->db		= \Config\Database::connect();
	}
	
    public function index()
    {
		// helper
		Helper('web');
		
		// model
		$menuModel = new \App\Models\MenuModel();
		
		// library
		// $perm = new Perm(); // create an instance of Library
		$perm = new \App\Libraries\Perm;
		
		$boxMenu = "";
		
		$getMenu = $menuModel->where( array("statusId" => 1, "menuLevel" => 2) )->orderBy("menuOrder", "asc")->findAll();	
		foreach ($getMenu as $menu) {
			if ( $perm->role($menu->menuId, 'view') ) {
				$boxMenu .= "<div title='" . $menu->title . "' style='padding:10px'>";
					$getMenuChild = $menuModel->where( array("menuPid" => $menu->menuId, "statusId" => 1) )->orderBy('menuOrder', 'asc')->findAll();
					foreach ($getMenuChild as $menuChild) {
						if ( $perm->role($menuChild->menuId, 'view') ) {
							$boxMenu .= "<a href=" . $menuChild->url . ">";
							$boxMenu .= "<div class='tag-box'>";
							
							$boxMenu .= "<div>" . ucwords(strtolower($menuChild->menu)) . "</div>";
							$boxMenu .= "<img src=" . base_url('assets/images/icons/' . $menuChild->icon) . " height='64px'>";
							$boxMenu .= "<div>" . ucwords(strtolower($menuChild->title)) . "</div>";
							
							$boxMenu .= "</div>";
							$boxMenu .= "</a>";
						}
					}
				$boxMenu .= "</div>";
			}
		}
		
		$data = array(
			'boxMenu'		=> $boxMenu
		);
        return view('home', $data);
    }
	
	public function changePassword()
	{
		header("HTTP/1.1 200 OK");
		header('Content-Type: application/json');
		
		try {
			
			if(!isset($_POST))	
				show_404();
			
			if ( empty($this->request->getPost("oldPassword")) ) {
				throw new \Exception("Incorrect oldPassword.");
			}
			if ( empty($this->request->getPost("newPassword")) ) {
				throw new \Exception("Incorrect newPassword.");
			}
			if ( empty($this->request->getPost("confirmPassword")) ) {
				throw new \Exception("Incorrect confirmPassword.");
			}
			if ( $this->request->getPost("newPassword") != $this->request->getPost("confirmPassword") ) {
				throw new \Exception("newPassword, confirmPassword does not match.");
			}
			
			if ( empty($this->request->getPost("userId")) ) {
				throw new \Exception("Incorrect userId.");
			}
			
			$usersModel = new \App\Models\UsersModel();
			
			$users = $usersModel->where( array("userId" => $this->request->getPost("userId"), "statusId" => 1) )->first();	
			if ( $users->password != hash('sha256', $this->request->getPost("oldPassword")) ) {
				throw new \Exception("wrong oldPassword.");
			}
			
			$paramUpdate = array(
				'password' => $this->request->getPost("newPassword")
			);
			$updateStatus = $usersModel->update(array('userId' => $this->request->getPost("userId")), $paramUpdate);
			
			if($updateStatus) {
				echo json_encode(array('status' => "success", 'message'=>'Success Change Password'));
			} else {
				echo json_encode(array('status' => "failed", 'message'=>'Update Failed'));
			}
		
		} catch(\Exception $ex)
		{
			echo json_encode(array('status' => "failed", 'message' => $ex->getMessage()));
		}
		
	}
}
