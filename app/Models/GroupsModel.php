<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'groups';
    protected $primaryKey       = 'groupId';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = ['groupId', 'groupName', 'description', 'statusId', 'inputBy', 'updateBy', 'deleteBy'];

    // Dates
    protected $useTimestamps = true;
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
    protected $afterDelete    = ['callAfterDelete'];
	
	public function getAll($pagination = "")
    {
		return $this->getData($pagination)->getResult();
	}
	
	public function getCount($pagination = "")
    {
		return $this->getData($pagination)->getNumRows();
	}
	
	// Listing Table
    protected function getData($pagination = "")
    {
		$sql = "SELECT groups.* FROM groups";
		$sql .= " WHERE groups.statusId!=0";
		if ( isset($_POST['groupName'])) 
		{
			$sql .= " AND groups.groupName LIKE '%" . $_POST['groupName'] . "%'";
		}
		
		if ( isset($_POST['description'])) 
		{
			$sql .= " AND groups.description LIKE '%" . $_POST['description'] . "%'";
		}
		
		if ( $pagination != "" ) {
			
			$rows 	= $pagination["rows"];
			$sort	= $pagination["sort"];
			$order	= $pagination["order"];
			$offset = $pagination["offset"];
			$sql .= " ORDER BY $sort $order limit $offset,$rows";
		}
		
        $builder = $this->db->query($sql);
        return $builder;
    }
	
	protected function callAfterDelete(array $data)
    {
		if (! isset($data['id']['0'])) {
            return $data;
        }
		
		$groupId = addslashes($data['id']['0']); // groupId
		
        $sql = "UPDATE `groups` SET `statusId`=0, `deleteBy`='".session()->get('userId')."' WHERE `groupId`='".$groupId."';";

        $builder = $this->db->query($sql);
		
		return $data;
    }
	
	// public function autoGroupsId($configName)
	// {
		// $builder = $this->db->query("SELECT prefix, max(RIGHT(number, 6)) as numberId FROM `auto_number` WHERE `configName`='" . $configName . "'");
		
		// $numberIncrement = 1 + $builder->getRow()->numberId;
		// $NumberSprint = "" . sprintf("%06s", $numberIncrement) ;
		// return $builder->getRow()->prefix . $NumberSprint;
	// }
	
	// protected function callAfterInsert(array $data)
    // {
		// if (! isset($data['data']['groupId'])) {
            // return $data;
        // }
		
		// $groupId = substr($data['data']['groupId'], -6);
		
        // $sql = "UPDATE `db`.`auto_number` SET `number`='".$groupId."' WHERE `configName`='groupId';";

        // $builder = $this->db->query($sql);
		
		// return $data;
    // }
}
