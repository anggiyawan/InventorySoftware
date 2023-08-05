<?php //if (!defined('BASEPATH')) exit('No direct script access allowed');

namespace App\Libraries;
 
class Perm {
 
    public $user_id;
    public $username;
    public $email;
    public $is_login;

	
    public function __construct()
    {
		$this->db = db_connect();
    }

    public function role($menuId, $akses)
    {
		$groupsRolesModel = new \App\Models\GroupsRolesModel();
		$groupsRoles = $groupsRolesModel->asObject()->select($akses)->where( array("menuId" => $menuId, "groupId" => session()->get("groupId")) )->first();
		return @$groupsRoles->$akses;		
    }
	
	public function menuChild($menuId, $akses)
    {
		$groupsRolesModel = new \App\Models\GroupsRolesModel();
		$groupsRoles = $groupsRolesModel->asObject()->select($akses)->where( array("menuId" => $menuId, "groupId" => session()->get("groupId")) )->first();
		return @$groupsRoles->$akses;		
    }
	
	public function superadmin()
    {
		
		$CI =& get_instance();
		
		if ( session()->get("groupId") == "100001" )
			return TRUE;
		else
			return FALSE;
		
    }
	
    public function userId()
    {
		return session()->get("userId");
    }
	

}