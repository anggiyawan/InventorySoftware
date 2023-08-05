<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesOrdersAmountModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sales_orders_amount';
    protected $primaryKey       = 'salesOrderAmountId';
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
	
	public function getData($pagination = "")
    {		
		$sql = "SELECT sales_orders_amount.*, sales_orders.salesOrderNumber FROM sales_orders_amount
		LEFT JOIN sales_orders ON sales_orders_amount.salesOrderId=sales_orders.salesOrderId";
		$sql .= " WHERE sales_orders_amount.statusId!=0";
		$sql .= " AND sales_orders.statusId!=0";
		
		if ( !empty($_GET['salesOrderId'])) 
		{
			$sql .= " AND sales_orders_amount.salesOrderId='" . $_GET['salesOrderId'] . "'";
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
	
	public function updateOrInsert($salesOrderId, $name, $title, $value)
    {
		// if (empty($source)) {
            // throw new \Exception("moveStock `source` empty");
        // }
		
		$rowSalesAmount = $this->db->query("SELECT salesOrderId FROM `sales_orders_amount` WHERE salesOrderId='{$salesOrderId}' AND name='{$name}'")->getNumRows();
		// log_message("error", $rowSalesAmount);
		if ( $rowSalesAmount >= 1 ) {
			// Update
			$this->db->query("UPDATE `sales_orders_amount`
			SET `title`='{$title}', `value`='{$value}' WHERE salesOrderId='{$salesOrderId}' AND name='{$name}'");
		} else {
			// Insert
			$this->db->query("INSERT INTO `sales_orders_amount` 
			(salesOrderId, name, value, title, statusId) 
			values('{$salesOrderId}', '{$name}', '{$value}', '{$title}', 1)");
		}
		
		return;
    }
	
	// Listing Join
    // public function getData($pagination = "")
    // {
		// $sql = "SELECT sales_orders.*, users.userName
		// FROM sales_orders
		// LEFT JOIN users ON sales_orders.inputBy=users.userId";
		// $sql .= " WHERE sales_orders.statusId!=0";
		
		// if ( !empty($_POST['salesOrderId'])) 
		// {
			// $sql .= " AND sales_orders.salesOrderId LIKE '%" . $_POST['salesOrderId'] . "%'";
		// }
		
		// if ( !empty($_POST['customerId'])) 
		// {
			// $sql .= " AND sales_orders.customerId LIKE '%" . $_POST['customerId'] . "%'";
		// }
		
		// if ( !empty($_POST['customerName'])) 
		// {
			// $sql .= " AND sales_orders.customerName LIKE '%" . $_POST['customerName'] . "%'";
		// }
		
		// if ( !empty($_POST['salesOrderNumber'])) 
		// {
			// $sql .= " AND sales_orders.salesorderNumber LIKE '%" . $_POST['salesOrderNumber'] . "%'";
		// }
		
		// if ( !empty($_POST['status'])) 
		// {
			// $sql .= " AND sales_orders.statusId='" . $_POST['status'] . "'";
		// }
		
		// if ( $pagination != "" ) {
			
			// $rows 	= $pagination["rows"];
			// $sort	= $pagination["sort"];
			// $order	= $pagination["order"];
			// $offset = $pagination["offset"];
			// $sql .= " ORDER BY $sort $order limit $offset,$rows";
		// }
		
        // $builder = $this->db->query($sql);
        // return $builder;
    // }
	
	// protected function callAfterDelete(array $data)
    // {
		// if (! isset($data['id']['0'])) {
            // return $data;
        // }
		
		// $salesOrderId = addslashes($data['id']['0']); // salesOrderId
		
        // $sql = "UPDATE `sales_orders` SET `statusId`=0, `deleteBy`='".session()->get('userId')."' WHERE `salesOrderId`='".$salesOrderId."';";

        // $builder = $this->db->query($sql);
		
		// return $data;
    // }
	
}