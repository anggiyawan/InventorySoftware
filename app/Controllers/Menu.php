<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Menu extends BaseController
{
	public function __construct()
	{
		// $this->db		= \Config\Database::connect();
		$this->request	= \Config\Services::request();
		// $this->session	= \Config\Services::session();
		// $this->validation =  \Config\Services::validation();
	}
	
    public function index()
    {
        //
    }
	
	public function manage()
    {		
		// get model table
		$menuTypeModel = new \App\Models\MenuTypeModel();
		$getMenu = $menuTypeModel->findAll();	
		// $data['menu_type'] 		= $this->db->get('menu_type')->result();
			// $type = urldecode(str_replace('-', ' ', $type));
			// $data['admin_menu'] 	= $this->get_menu($type);
			// $this->load->view('menu', $data);
			
		$data = array(
			'menuType'		=> $getMenu
		);
        return View('menu/menu', $data);
    }
	
	public function addMenu($type = 'menu-primary')
	{
		$type				= urldecode(str_replace('-', ' ', $type));

		// get model table
		$menuTypeModel = new \App\Models\MenuTypeModel();
		$getMenuType = $menuTypeModel->where(array('type' => $type))->first();

		$data = array(
			'menuTypeId'		=> @$getMenuType->menuTypeId
		);
		return View('menu/menuAdd', $data);
	}
	
	public function updateMenu($menu = null, $return = true)
    {
		header('Content-Type: application/json');
		
        if ($menu == null) {
            $type = $this->request->getPost('type');
            $menu = $this->request->getPost('jsonMenu');
        }
        $decode = json_decode($menu);

        $this->decode_menu($decode);
        if ($return) {
			echo json_encode(array('status' => "success", 'message'=>'Success'));
        } else {
			echo json_encode(array('status' => "failed", 'message'=>'Failed'));
		}
    }
	
	public function editMenu($id)
	{
		// get model table
		$menuModel = new \App\Models\MenuModel();
		$data = array(
			'menu'		=> @$menuModel->where(array('menuId' => $id))->first()
		);
		return View('menu/menuEdit', $data);
	}
	
	public function deleteMenu()
	{
		header('Content-Type: application/json');
		
		try
		{	
			if(empty( $this->request->getPost("menuId") )) {
				throw new \Exception("Data Empty.");
			}
			
			$menuId = addslashes($this->request->getPost("menuId"));
			
			// get model table
			$menuModel = new \App\Models\MenuModel();
			
            // delete groups
			$deleteMenu = $menuModel->where('menuId', $menuId)->delete();
			// var_dump($deleteMenu); exit;
			if($deleteMenu) {
				$returnValue = json_encode(array('status' => "success", 'message'=>'Success delete menu'));
			} else {
				$returnValue = json_encode(array('status' => "failed", 'message'=>'Delete Failed'));
			}
		}
		catch(Exception $ex)
		{
			$returnValue = json_encode(array('status' => "failed", "message" => $ex->getMessage()));
		}
		
		echo $returnValue;
	}
	
	public function menuSave()
	{
		header('Content-Type: application/json');
		
		$id = @$this->request->getPost('menuId');
		$data = array(
			'menuTypeId'	=> $this->request->getPost('menuTypeId'),
			'menu'			=> $this->request->getPost('menu'),
			'title'			=> $this->request->getPost('title'),
			'url'			=> $this->request->getPost('url'),
			'icon'			=> $this->request->getPost('icon'),
			
			'view'			=> ($this->request->getPost('view')) ? '1' : '0',
			'created'		=> ($this->request->getPost('created')) ? '1' : '0',
			'updated'		=> ($this->request->getPost('updated')) ? '1' : '0',
			'cancelled'		=> ($this->request->getPost('cancelled')) ? '1' : '0',
			'deleted'		=> ($this->request->getPost('deleted')) ? '1' : '0',
			'printed'		=> ($this->request->getPost('printed')) ? '1' : '0',
			'downloaded'	=> ($this->request->getPost('downloaded')) ? '1' : '0',
			// 'uploaded'		=> ($this->request->getPost('uploaded')) ? '1' : '0',
			'closed'		=> ($this->request->getPost('closed')) ? '1' : '0',
			'verified'		=> ($this->request->getPost('verified')) ? '1' : '0',
			'statusId'		=> 1,
		);
		
		$menuModel = new \App\Models\MenuModel();
		if ($id) {
            // $this->db->where('menu_id', $id);
            // $this->db->update('menu', $data);
			$updateMenu = $menuModel->update(array('menuId' => $id), $data);
			
			if($updateMenu) {
				echo json_encode(array('status' => "success", 'message'=>'Success Change Password'));
			} else {
				echo json_encode(array('status' => "failed", 'message'=>'Update Failed'));
			}
		} else {
			$menuModel->insert($data);
			echo json_encode(array('status' => "success", 'message'=>'Success'));
		}
	}
	
	public function onloadMenu($type = 'menu-primary')
	{
		$menuTypeModel = new \App\Models\MenuTypeModel();
		
		$type = urldecode(str_replace('-', ' ', $type));
		
		$data['menu_type']	= @$menuTypeModel->where(array('type' => $type))->first()->menuTypeId;	//@$this->db->get_where('menu_type', array('type' => $type))->row()->menuTypeId;
		$data['admin_menu'] 	= $this->getMenu($type);
		return View('menu/menuLoad', $data);
	}
	
	private function getMenu($type)
    {
        // $this->db->where('status_id = 1');
        // $this->db->where('type = "'.$type.'"');
        // $this->db->join('menu_type', 'menu_type.id_menu_type = menu.id_menu_type', 'left');
        // $this->db->order_by('menu_order', 'ASC');
        // $menus = $this->db->get('menu')->result_array();
		$menuModel = new \App\Models\MenuModel();
		
		$param = array('type' => $type);
		$menus = $menuModel->getAll($param);
        return $this->get_nestable_menu($menus);
    }
	
	private function get_nestable_menu($menus, $parent_id = 0)
    {
        $list_menu = '';
        foreach ($menus as $menu) {
            if ($parent_id == $menu->menuPid) {
                $type = urldecode(str_replace(' ', '-', strtolower($menu->type)));
                $list_menu .= '<li class="dd-item" data-id="'.$menu->menuId.'">
                <div class="dd-handle bg-light-blue">
					'.$menu->menu.'
				</div>
				<p>
					<span class="dd-action">
					  <!--<a href="'.base_url('menu/editMenu/'.$type.'/edit/'.$menu->menuId).'" title="edit"><i class="fa fa-edit" style="color:green"></i></a>
					  <a href="'.base_url('menu/deleteMenu/' . $menu->menuId).'" title="Delete" class="delete-confirm" onclick="confirm(\'Yakin ingin menghapus data ini ?\')"><i class="fa fa-trash"></i></a>-->
					  <a href="javascript:void(0)" title="edit" onclick="updateMenu(' . $menu->menuId . ')"><i class="fa fa-edit" style="color:green"></i></a>
					  <a href="javascript:void(0)" title="delete" onclick="deleteMenu(' . $menu->menuId . ')"><i class="fa fa-trash" style="color:brown"></i></a>
					</span>
				</p>';
                $list_menu .= $this->get_nestable_menu($menus, $menu->menuId);
                $list_menu .= '</li>';
            }
        }

        if ($list_menu != '') {
            return '<ol class="dd-list">'.$list_menu.'</ol>';
        } else {
            return;
        }
    }
	
	/**
     * Save menu into database.
     *
     * @return array
     **/
    public function decode_menu($menu, $parentId = null, $level = null, $sort = null)
    {
		$menuModel = new \App\Models\MenuModel();
		
        if ($parentId == null && $level == null) {
            $parentId = 0;
            if ($this->request->uri->getSegment(3) == 'side_menu') {
                $level = 0;
            } else {
                $level = 1;
            }
        }

        if ($sort == null) {
            $sort = 0;
        }
        foreach ($menu as $value) {
            $data = array (
					'menuOrder'	=> $sort, 
					'menuId'	=> $value->id, 
					'menuLevel' => $level, 
					'menuPid'	=> $parentId
			);

            // $this->db->where('menu_id', $value->id);
            // $this->db->update('menu', $update_menu);
			$menuModel->update(array('menuId' => $value->id), $data);
			
            ++$sort;

            if (isset($value->children)) {
                $sort = $this->decode_menu($value->children, $value->id, $level + 1, $sort);
            }
        }

        return $sort;
    }
	
	public function getIconMenu()
	{
		// * Create Comment 13 April 2021
		header('Content-Type: application/json');
		
		$dir = "assets/images/icons/";
		if (is_dir($dir)) {
				$images = [];
				
				$a = scandir($dir);
				$files = glob($dir . '*.png');
				$number = 0;
				
				if ( $files !== false )
				{
					$filecount = count( $files );
					if ( $filecount <= 0 )
						throw new Exception("File is clear");
		
					foreach($a as $key => $filename)
					{
						$dirImage = $dir . $filename;
						
					  if ( file_exists($dir . substr($filename, 0, -4) . ".png") ){
						  $number += 1;
						  $row[] = array(
							'id'			=> $number,
							'description'	=> $filename,
							'img'			=> $filename
						);
					  }
					}
					
					$returnValue = json_encode(array('status' => "00", 'message'=> 'Success'));
				} else {
					$returnValue = json_encode(array('status' => "01", 'message'=> 'File is clear'));
				}
				
			}
			
		echo json_encode($row);
	}
}
