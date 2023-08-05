<?php

namespace App\Models;

use CodeIgniter\Model;

class RepresentativesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'representative';
    protected $primaryKey       = 'representativeId';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = [];

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
    protected $afterDelete    = ["callAfterDelete"];
	
	public function getAll($pagination = "")
    {
		return $this->getData($pagination)->getResult();
	}
	
	public function getCount($pagination = "")
    {
		return $this->getData($pagination)->getNumRows();
	}
	
	// Listing Join
    public function getData($pagination = "")
    {
		$sql = "SELECT representative.* FROM representative";
		$sql .= " WHERE representative.statusId!=0";
		if ( isset($_POST['representativeId'])) 
		{
			$sql .= " AND representative.representativeId LIKE '%" . $_POST['representativeId'] . "%'";
		}
		
		if ( isset($_POST['representative'])) 
		{
			$sql .= " AND representative.representative LIKE '%" . $_POST['representative'] . "%'";
		}
		
		if ( isset($_POST['description'])) 
		{
			$sql .= " AND representative.description LIKE '%" . $_POST['description'] . "%'";
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
		
		$representativeId = addslashes($data['id']['0']); // representativeId
		
        $sql = "UPDATE `representative` SET `statusId`=0, `deleteBy`='".session()->get('userId')."' WHERE `representativeId`='".$representativeId."';";

        $builder = $this->db->query($sql);
		
		return $data;
    }
}
