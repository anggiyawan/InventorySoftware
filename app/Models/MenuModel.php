<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'menu';
    protected $primaryKey       = 'menuId';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['menuPid', 'menuTypeId', 'statusId', 'menuOrder', 'menu', 'title', 'url', 'icon', 'menuLevel', 'view', 'created', 'updated', 'cancelled', 'deleted', 'printed', 'downloaded', 'closed', 'verified'];

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
	
	public function getAll(array $param)
    {
		$sql = "SELECT menu.*, menu_type.menuTypeId, menu_type.type FROM menu INNER JOIN menu_type ON menu.menuTypeId=menu_type.menuTypeId";
		$sql .= " AND menu.statusId=1";
		if ( isset($param['type'])) 
		{
			// var_dump($param['type']);
			$sql .= " AND menu_type.type='" . $param['type'] . "'";
		}
		
		// if ( isset($_POST['groupId'])) 
		// {
			// $sql .= " AND groups.groupId LIKE '%" . $_POST['groupId'] . "%'";
		// }
		
		$sql .= " ORDER BY menuOrder asc";
		
        $builder = $this->db->query($sql);
        return $builder->getResult();
    }
}
