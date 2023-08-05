<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupsRolesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'groups_roles';
    protected $primaryKey       = 'groupRolesId';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['groupRolesId', 'groupId', 'menuId', 'view', 'created', 'updated', 'cancelled', 'deleted', 'printed', 'downloaded', 'closed', 'verified'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'inputDate';
    protected $updatedField  = 'updateDate';
    protected $deletedField  = 'deleteDate';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
	
	public function checkMenuId($menuId, $groupId) {
		$sql = "SELECT * FROM groups_roles WHERE menuId='" . $menuId . "' AND groupId='" . $groupId . "'";
		$query = $this->db->query($sql);
		
		if ( $query->getNumRows() > 0 ) {
			return 1;
		} else {
			return 0;
		}
	}
}
