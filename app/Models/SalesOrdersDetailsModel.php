<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesOrdersDetailsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sales_orders_details';
    protected $primaryKey       = 'salesOrderDetailId';
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
		$sql = "SELECT sales_orders_details.*, sales_orders.salesOrderId, sales_orders.salesOrderNumber FROM sales_orders_details
		LEFT JOIN sales_orders ON sales_orders_details.salesOrderId=sales_orders.salesOrderId";
		$sql .= " WHERE sales_orders_details.statusId!=0";
		$sql .= " AND sales_orders.statusId!=0";
		
		if ( !empty($_GET['salesOrderId'])) 
		{
			$sql .= " AND sales_orders_details.salesOrderId='" . $_GET['salesOrderId'] . "'";
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
	
	public function getPacked($salesOrderDetailId)
    {
		$sql = "SELECT IFNULL(sum(packages_details.quantityToPack), 0) as packed FROM packages_details";
		$sql .= " WHERE packages_details.statusId!=0";
		
		if ( !empty($salesOrderDetailId) ) 
		{
			$sql .= " AND packages_details.salesOrderDetailId='" . $salesOrderDetailId . "'";
		}
		
        $builder = $this->db->query($sql)->getRow()->packed;
		// log_message('error', $sql);
        return $builder;
    }
	
	// get quantity delivered
	public function getDelivered($salesOrderDetailId, $productId, $deliveryOrderDetailId = "")
    {
		$sql = "SELECT IFNULL(sum(delivery_orders_details.quantity), 0) as quantity FROM delivery_orders_details
		INNER JOIN delivery_orders ON delivery_orders_details.deliveryOrderId=delivery_orders.deliveryOrderId";
		$sql .= " WHERE delivery_orders_details.statusId!=0";
		$sql .= " AND delivery_orders.statusId!=0";
		
		if ( !empty($salesOrderDetailId) ) 
		{
			$sql .= " AND delivery_orders_details.salesOrderDetailId='" . $salesOrderDetailId . "'";
		}
		
		if ( !empty($productId) ) 
		{
			$sql .= " AND delivery_orders_details.productId='" . $productId . "'";
		}
		
		if ( !empty($deliveryOrderDetailId) ) 
		{
			$sql .= " AND delivery_orders_details.deliveryOrderDetailId!='" . $deliveryOrderDetailId . "'";
		}
		
        $builder = $this->db->query($sql)->getRow()->quantity;
		// log_message('error', $sql);
        return $builder;
    }
	
	public function deleteBySalesOrderId($salesOrderId = null)
    {
		if ($salesOrderId == null) {
            return;
        }
		
		$salesOrderId = addslashes($salesOrderId); // salesOrderId
		
        $sql = "UPDATE `sales_orders_details` SET `statusId`=0, `deleteBy`='".session()->get('userId')."' WHERE `salesOrderId`='".$salesOrderId."';";

        return $this->db->query($sql);
    }
	
	/*
	public function getData()
    {
		$sql = "SELECT sales_orders_details_temp.* FROM sales_orders_details_temp";
		$sql .= " WHERE sales_orders_details_temp.statusId!=0";
		$sql .= " AND sales_orders_details_temp.inputBy='" . session()->get("userId") . "'";
		
		if ( isset($_GET['salesOrderDetailId'])) 
		{
			$sql .= " AND sales_orders_details_temp.salesOrderDetailId LIKE '%" . $_POST['salesOrderDetailId'] . "%'";
		}
		
		// if ( isset($_POST['groupId'])) 
		// {
			// $sql .= " AND sales_orders_details_temp.groupId LIKE '%" . $_POST['groupId'] . "%'";
		// }
		
		$sql .= " ORDER BY inputDate desc";
		
        $builder = $this->db->query($sql);
        return $builder;
    }
	*/
	
}
