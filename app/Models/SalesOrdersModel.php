<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesOrdersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sales_orders';
    protected $primaryKey       = 'salesOrderId';
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
		$sql = "SELECT sales_orders.*, users.userName
		FROM sales_orders
		LEFT JOIN users ON sales_orders.inputBy=users.userId";
		$sql .= " WHERE sales_orders.statusId!=0";
		
		if ( !empty($_POST['salesOrderId'])) 
		{
			$sql .= " AND sales_orders.salesOrderId LIKE '%" . $_POST['salesOrderId'] . "%'";
		}
		
		if ( !empty($_POST['customerId'])) 
		{
			$sql .= " AND sales_orders.customerId LIKE '%" . $_POST['customerId'] . "%'";
		}
		
		if ( !empty($_POST['customerName'])) 
		{
			$sql .= " AND sales_orders.customerName LIKE '%" . $_POST['customerName'] . "%'";
		}
		
		if ( !empty($_POST['salesOrderNumber'])) 
		{
			$sql .= " AND sales_orders.salesorderNumber LIKE '%" . $_POST['salesOrderNumber'] . "%'";
		}
		
		if ( !empty($_POST['status'])) 
		{
			$sql .= " AND sales_orders.statusId='" . $_POST['status'] . "'";
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
	
	public function changeStatus($salesOrderId, $statusId)
    {
		if ( empty($salesOrderId) || empty($statusId) )
		{
            return;
        }
		
		// udah ga kepake lagi
		// if ($statusId >= \SALES_ORDER_STATUS::CONFIRM) {
			// $getSalesOrdersDetails = $this->db->query("SELECT `productId`, `quantity` FROM `sales_orders_details` WHERE salesOrderId=" . $salesOrderId);
			// foreach($getSalesOrdersDetails->getResult() as $salesOrderDetail) {
				// $this->db->query("UPDATE `products` SET 
				// `stockAccCommit`=`stockAccCommit`+" . (int)$salesOrderDetail->quantity . ",
				// `stockAccSale`=`stockAccHand`-`stockAccCommit`,
				
				// `stockPhyCommit`=`stockPhyCommit`+" . (int)$salesOrderDetail->quantity . ",
				// `stockPhySale`=`stockPhyHand`-`stockPhyCommit`
				// WHERE `productId`='" . $salesOrderDetail->productId . "'");
			// }
		// }
		
		$salesOrderId = addslashes($salesOrderId); // salesOrderId
		
        $sql = "UPDATE `sales_orders` SET `statusId`=" . $statusId . ", `updateBy`='" . session()->get('userId') . "' WHERE `salesOrderId`='".$salesOrderId."';";

        $builder = $this->db->query($sql);
		
		return;
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
		
		// udah ga kepake lagi
		// $getSalesOrders = $this->db->query("SELECT `statusId` FROM `sales_orders` WHERE salesOrderId=" . $salesOrderId);
		// log_message('error', $getSalesOrders->getRow()->statusId);
		// if ($getSalesOrders->getRow()->statusId >= \SALES_ORDER_STATUS::CONFIRM) {
			// $getSalesOrdersDetails = $this->db->query("SELECT `productId`, `quantity` FROM `sales_orders_details` WHERE salesOrderId=" . $salesOrderId);
			// foreach($getSalesOrdersDetails->getResult() as $salesOrderDetail) {
				// $this->db->query("UPDATE `products` SET 
				// `stockAccCommit`=`stockAccCommit`-" . (int)$salesOrderDetail->quantity . ",
				// `stockAccSale`=`stockAccHand`+`stockAccCommit`,
				
				// `stockPhyCommit`=`stockPhyCommit`-" . (int)$salesOrderDetail->quantity . ",
				// `stockPhySale`=`stockPhyHand`+`stockPhyCommit`
				// WHERE `productId`='" . $salesOrderDetail->productId . "'");
			// }
			// log_message('error', $salesOrderDetail->quantity);
		// }
		
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
	
}