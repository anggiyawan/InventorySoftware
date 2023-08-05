<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryOrdersDetailsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'delivery_orders_details';
    protected $primaryKey       = 'deliveryOrderDetailId';
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
    protected $afterDelete    = ["callAfterDelete"];
	
	public function getAll()
    {
		return $this->getData()->getResult();
	}
	
	public function getCount()
    {
		return $this->getData()->getNumRows();
	}
	
	// // Listing Join
    public function getData()
    {
		$sql = "SELECT delivery_orders_details.*, sales_orders_details.productId, sales_orders_details.productName, sales_orders_details.productNumber, delivery_orders.sourceLocationId FROM delivery_orders_details
		LEFT JOIN delivery_orders ON delivery_orders.deliveryOrderId=delivery_orders_details.deliveryOrderId
		LEFT JOIN sales_orders_details ON sales_orders_details.salesOrderDetailId=delivery_orders_details.salesOrderDetailId";
		$sql .= " WHERE delivery_orders_details.statusId!=0";
		$sql .= " AND delivery_orders.statusId!=0";
		
		if ( !empty($_GET['deliveryOrderId'])) 
		{
			$sql .= " AND delivery_orders_details.deliveryOrderId='" . $_GET['deliveryOrderId'] . "'";
		}
		
		// if ( isset($_POST['userName'])) 
		// {
			// $sql .= " AND delivery_orders_details.userName LIKE '%" . $_POST['userName'] . "%'";
		// }
		
		$sql .= " ORDER BY deliveryOrderDetailId desc";
		
        $builder = $this->db->query($sql);
        return $builder;
    }
	
	public function getResultData($where)
    {
		$sql = "SELECT delivery_orders_details.*, sales_orders_details.productId, sales_orders_details.productName, sales_orders_details.productNumber, delivery_orders.sourceLocationId FROM delivery_orders_details
		LEFT JOIN delivery_orders ON delivery_orders.deliveryOrderId=delivery_orders_details.deliveryOrderId
		LEFT JOIN sales_orders_details ON sales_orders_details.salesOrderDetailId=delivery_orders_details.salesOrderDetailId";
		$sql .= " WHERE delivery_orders_details.statusId!=0";
		$sql .= " AND delivery_orders.statusId!=0";
		
		if ( !empty($where['deliveryOrderId'])) 
		{
			$sql .= " AND delivery_orders_details.deliveryOrderId='" . $where['deliveryOrderId'] . "'";
		}
		
		if ( !empty($where['statusId'])) 
		{
			$sql .= " AND delivery_orders_details.statusId='" . $where['statusId'] . "'";
		}
		
        $builder = $this->db->query($sql);
        return $builder;
    }
	
	protected function callAfterDelete(array $data)
    {
		if (! isset($data['id']['0'])) {
            return $data;
        }
		
		$deliveryOrderDetailId = addslashes($data['id']['0']); // deliveryOrderDetailId
		
        $sql = "UPDATE `delivery_orders_details` SET `statusId`=0, `deleteBy`='".session()->get('userId')."' WHERE `deliveryOrderDetailId`='".$deliveryOrderDetailId."';";

        $builder = $this->db->query($sql);
		
		return $data;
    }
	
	// public function autoDeliveryOrdersNumber()
	// {
		// $configName = \AUTONUMBER::PACKING_SLIP;
		// $builder = $this->db->query("SELECT prefix, max(RIGHT(number, 6)) as numberId FROM `auto_number` WHERE `configName`='" . $configName . "'");
		
		// $numberIncrement = 1 + $builder->getRow()->numberId;
		// $NumberSprint = "" . sprintf("%06s", $numberIncrement) ;
		// return $builder->getRow()->prefix . $NumberSprint;
	// }
	
}
