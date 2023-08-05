<?php

namespace App\Models;

use CodeIgniter\Model;

class PackagesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'packages';
    protected $primaryKey       = 'packageId';
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
    protected $afterDelete    = [];
	
	public function getAll()
    {
		return $this->getData()->getResult();
	}
	
	public function getCount()
    {
		return $this->getData()->getNumRows();
	}
	
	// Listing Join
    public function getData()
    {
		$sql = "SELECT users.*, groups.groupId, groups.groupName FROM users INNER JOIN groups ON users.groupId=groups.groupId";
		$sql .= " AND users.statusId!=0";
		if ( isset($_POST['userName'])) 
		{
			$sql .= " AND users.userName LIKE '%" . $_POST['userName'] . "%'";
		}
		
		if ( isset($_POST['groupId'])) 
		{
			$sql .= " AND groups.groupId LIKE '%" . $_POST['groupId'] . "%'";
		}
		
		$sql .= " ORDER BY inputDate desc";
		
        $builder = $this->db->query($sql);
        return $builder;
    }
	
	public function autoPackageNumber()
	{
		$configName = \AUTONUMBER::PACKING_SLIP;
		$builder = $this->db->query("SELECT prefix, max(RIGHT(number, 6)) as numberId FROM `auto_number` WHERE `configName`='" . $configName . "'");
		
		$numberIncrement = 1 + $builder->getRow()->numberId;
		$NumberSprint = "" . sprintf("%06s", $numberIncrement) ;
		return $builder->getRow()->prefix . $NumberSprint;
	}
	
}
