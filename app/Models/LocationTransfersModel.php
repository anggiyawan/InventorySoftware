<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationTransfersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'location_transfers';
    protected $primaryKey       = 'locationTransferId';
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
    protected $afterInsert    = ['callAfterInsert'];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = ['callAfterDelete'];
	
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
		$sql = "SELECT location_transfers.*, users.userName FROM location_transfers
		LEFT JOIN users ON location_transfers.inputBy=users.userId";
		$sql .= " WHERE location_transfers.statusId!=0";
		
		if ( isset($_POST['reffNumber'])) 
		{
			$sql .= " AND location_transfers.reffNumber LIKE '%" . $_POST['reffNumber'] . "%'";
		}
		
		if ( isset($_POST['remark'])) 
		{
			$sql .= " AND location_transfers.remark LIKE '%" . $_POST['remark'] . "%'";
		}
		
		// if ( $_POST['date'] != null ) 
		// { 
			$sql .= ' AND (location_transfers.inputDate BETWEEN "'. date('Y-m-d 00:00:00', strtotime($_POST['date'])). '" AND "'. date('Y-m-d 23:59:00', strtotime($_POST['date'] . ' + 1 days')) . '")';
		// }
		
		if ( $_POST['statusId'] != null) 
		{
			$sql .= " AND location_transfers.statusId='" . $_POST['statusId'] . "'";
		}
		
		$sql .= " ORDER BY inputDate desc";
		
        $builder = $this->db->query($sql);
        return $builder;
    }
	
	public function autoLocationTransferNumber()
	{
		$configName = \AUTONUMBER::LOCATION_TRANSFER;
		$builder = $this->db->query("SELECT prefix, max(RIGHT(number, 6)) as numberId FROM `auto_number` WHERE `configName`='" . $configName . "'");
		
		$numberIncrement = 1 + $builder->getRow()->numberId;
		$NumberSprint = "" . sprintf("%06s", $numberIncrement) ;
		return $builder->getRow()->prefix . $NumberSprint;
	}
	
	protected function callAfterInsert(array $data)
    {
		if (empty($data['data']['reffNumber'])) {
            return $data;
        }
		
		$configName = \AUTONUMBER::LOCATION_TRANSFER;
        $sql = "UPDATE `db`.`auto_number` SET `number`=(`number`+1) WHERE `configName`='" . $configName . "';";

        $builder = $this->db->query($sql);
		
		return $data;
    }
	
	protected function callAfterDelete(array $data)
    {
		if (! isset($data['id']['0'])) {
            return $data;
        }
		
		$locationTransferId = addslashes($data['id']['0']); // locationTransferId
		
        $sql = "UPDATE `location_transfers` SET `statusId`=0, `deleteBy`='".session()->get('userId')."' WHERE `locationTransferId`='".$locationTransferId."';";

        $builder = $this->db->query($sql);
		
		return $data;
    }
}
