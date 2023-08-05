<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationTransfersDetailsTempModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'location_transfers_details_temp';
    protected $primaryKey       = 'locationTransferDetailId';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
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
		$sql = "SELECT location_transfers_details_temp.* FROM location_transfers_details_temp";
		$sql .= " WHERE location_transfers_details_temp.inputBy!=''";
		$sql .= " AND location_transfers_details_temp.inputBy='" . session()->get("userId") . "'";
		
		if ( isset($_POST['productId'])) 
		{
			$sql .= " AND location_transfers_details_temp.productId LIKE '%" . $_POST['productId'] . "%'";
		}
		
		// if ( isset($_POST['remark'])) 
		// {
			// $sql .= " AND location_transfers_details_temp.remark LIKE '%" . $_POST['remark'] . "%'";
		// }
		
		// if ( $_POST['statusId'] != null) 
		// {
			// $sql .= " AND location_transfers_details_temp.statusId='" . $_POST['statusId'] . "'";
		// }
		
		$sql .= " ORDER BY inputDate desc";
		
        $builder = $this->db->query($sql);
        return $builder;
    }
	
	protected function callAfterDelete(array $data)
    {
		if (! isset($data['id']['0'])) {
            return $data;
        }
		
		$locationId = addslashes($data['id']['0']); // userId
		
        $sql = "UPDATE `location` SET `statusId`=0, `deleteBy`='".session()->get('userId')."' WHERE `locationId`='".$locationId."';";

        $builder = $this->db->query($sql);
		
		return $data;
    }
	
	// protected function callAfterInsert(array $data)
    // {
		// if (! isset($data['data']['userId'])) {
            // return $data;
        // }
		
		// $userId = substr($data['data']['userId'], -6);
		
        // $sql = "UPDATE `db`.`autoNumber` SET `number`='".$userId."' WHERE `configName`='userId';";

        // $builder = $this->db->query($sql);
		
		// return $data;
    // }
}
