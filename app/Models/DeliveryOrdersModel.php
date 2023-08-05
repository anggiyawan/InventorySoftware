<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryOrdersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'delivery_orders';
    protected $primaryKey       = 'deliveryOrderId';
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
    protected $afterInsert    = ["callAfterInsert"];
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
		$sql = "SELECT delivery_orders.*, sales_orders.salesOrderNumber, users.userName FROM delivery_orders
		LEFT JOIN sales_orders ON sales_orders.salesOrderId=delivery_orders.salesOrderId
		LEFT JOIN users ON users.userId=delivery_orders.inputBy";
		$sql .= " WHERE delivery_orders.statusId!=0";
		$sql .= " AND sales_orders.statusId!=0";
		
		if ( !empty($_POST['deliveryOrderId'])) 
		{
			$sql .= " AND delivery_orders.deliveryOrderId LIKE '%" . $_POST['deliveryOrderId'] . "%'";
		}
		
		if ( !empty($_POST['deliveryOrderNumber'])) 
		{
			$sql .= " AND delivery_orders.deliveryOrderNumber LIKE '%" . $_POST['deliveryOrderNumber'] . "%'";
		}
		
		if ( !empty($_POST['customerId'])) 
		{
			$sql .= " AND sales_orders.customerId LIKE '%" . $_POST['customerId'] . "%'";
		}
		
		if ( !empty($_POST['customerName'])) 
		{
			$sql .= " AND sales_orders.customerName LIKE '%" . $_POST['customerName'] . "%'";
		}
		
		if ( !empty($_POST['status'])) 
		{
			$sql .= " AND delivery_orders.statusId='" . $_POST['status'] . "'";
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
	
	protected function callAfterInsert(array $data)
    {
		// var_dump(empty($data['data']['salesOrderNumber'])); exit;
		if (empty($data['data']['deliveryOrderNumber'])) {
            return $data;
        }
		
		// $salesorderNumber = substr($data['data']['salesorderNumber'], -6);
		// var_dump($salesorderNumber); exit;
		$configName = \AUTONUMBER::DELIVERY_ORDER;
        $sql = "UPDATE `db`.`auto_number` SET `number`=(`number`+1) WHERE `configName`='" . $configName . "';";

        $builder = $this->db->query($sql);
		
		return $data;
    }
	
	protected function callAfterDelete(array $data)
    {
		if (! isset($data['id']['0'])) {
            return $data;
        }
		
		$deliveryOrderId = addslashes($data['id']['0']); // deliveryOrderId
		
        $sql = "UPDATE `delivery_orders` SET `statusId`=0, `deleteBy`='".session()->get('userId')."' WHERE `deliveryOrderId`='".$deliveryOrderId."';";

        $builder = $this->db->query($sql);
		
		return $data;
    }
	
	public function changeStatus($deliveryOrderId, $statusId)
    {
		if ( empty($deliveryOrderId) || empty($statusId) )
		{
            return $data;
        }
		
		if ($statusId >= \DELIVERY_ORDER_STATUS::CONFIRM) {
			$getDeliveryOrdersDetails = $this->db->query("SELECT `productId`, `quantity` FROM `delivery_orders_details` WHERE deliveryOrderId=" . $deliveryOrderId);
			foreach($getDeliveryOrdersDetails->getResult() as $deliveryOrderDetail) {
				$this->db->query("UPDATE `products` SET 
				`stockPhyHand`=`stockPhyHand`-" . (int)$deliveryOrderDetail->quantity . ",
				`stockPhyCommit`=`stockPhyCommit`-" . (int)$deliveryOrderDetail->quantity . "
				WHERE `productId`='" . $deliveryOrderDetail->productId . "'");
			}
			// throw new \Exception("error");
		}
		$deliveryOrderId = addslashes($deliveryOrderId); // deliveryOrderId
		
        $sql = "UPDATE `delivery_orders` SET `statusId`=" . $statusId . ", `updateBy`='" . session()->get('userId') . "' WHERE `deliveryOrderId`='".$deliveryOrderId."';";

        $builder = $this->db->query($sql);
		
		return $data;
    }
	
	public function autoDeliveryOrdersNumber()
	{
		$configName = \AUTONUMBER::DELIVERY_ORDER;
		$builder = $this->db->query("SELECT prefix, max(RIGHT(number, 6)) as numberId FROM `auto_number` WHERE `configName`='" . $configName . "'");
		
		$numberIncrement = 1 + $builder->getRow()->numberId;
		$NumberSprint = "" . sprintf("%06s", $numberIncrement) ;
		return $builder->getRow()->prefix . $NumberSprint;
	}
	
}
