<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesOrdersAddressModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sales_orders_address';
    protected $primaryKey       = 'salesOrderAddressId';
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
	
	/*
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
		$sql = "SELECT sales_orders.* FROM sales_orders";
		$sql .= " WHERE sales_orders.statusId!=0";
		
		if ( isset($_POST['salesOrderId'])) 
		{
			$sql .= " AND sales_orders.salesorderId LIKE '%" . $_POST['salesorderId'] . "%'";
		}
		
		if ( isset($_POST['customerId'])) 
		{
			$sql .= " AND sales_orders.customerId LIKE '%" . $_POST['customerId'] . "%'";
		}
		
		if ( isset($_POST['customerName'])) 
		{
			$sql .= " AND sales_orders.customerName LIKE '%" . $_POST['customerName'] . "%'";
		}
		
		if ( isset($_POST['salesorderNumber'])) 
		{
			$sql .= " AND sales_orders.salesorderNumber LIKE '%" . $_POST['salesorderNumber'] . "%'";
		}
		
		if ( isset($_POST['status'])) 
		{
			$sql .= " AND sales_orders.statusId='" . $_POST['status'] . "'";
		}
		
		$sql .= " ORDER BY inputDate desc";
		
        $builder = $this->db->query($sql);
        return $builder;
    }
	
	public function autoSalesOrderNumber()
	{
		$configName = \AUTONUMBER::SALES_ORDER_NUMBER;
		$builder = $this->db->query("SELECT prefix, max(RIGHT(number, 6)) as numberId FROM `auto_number` WHERE `configName`='" . $configName . "'");
		
		$numberIncrement = 1 + $builder->getRow()->numberId;
		$NumberSprint = "" . sprintf("%06s", $numberIncrement) ;
		return $builder->getRow()->prefix . $NumberSprint;
	}
	
	protected function callAfterDelete(array $data)
    {
		if (! isset($data['id']['0'])) {
            return $data;
        }
		
		$salesOrderId = addslashes($data['id']['0']); // salesOrderId
		
        $sql = "UPDATE `sales_orders` SET `statusId`=0, `deleteBy`='".session()->get('userId')."' WHERE `salesOrderId`='".$salesOrderId."';";

        $builder = $this->db->query($sql);
		
		return $data;
    }
	
	protected function callAfterInsert(array $data)
    {
		// var_dump(empty($data['data']['salesOrderNumber'])); exit;
		if (empty($data['data']['salesOrderNumber'])) {
            return $data;
        }
		
		// $salesorderNumber = substr($data['data']['salesorderNumber'], -6);
		// var_dump($salesorderNumber); exit;
		$configName = \AUTONUMBER::SALES_ORDER_NUMBER;
        $sql = "UPDATE `db`.`auto_number` SET `number`=(`number`+1) WHERE `configName`='" . $configName . "';";

        $builder = $this->db->query($sql);
		
		return $data;
    }
	*/
	
}