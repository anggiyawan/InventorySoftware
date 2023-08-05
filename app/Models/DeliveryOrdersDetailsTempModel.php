<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryOrdersDetailsTempModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'delivery_orders_details_temp';
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
		$sql = "SELECT delivery_orders_details_temp.*,
		sales_orders_details.productNumber,
		sales_orders_details.productName
		FROM delivery_orders_details_temp
		INNER JOIN sales_orders_details ON delivery_orders_details_temp.salesOrderDetailId=sales_orders_details.salesOrderDetailId";
		$sql .= " WHERE delivery_orders_details_temp.statusId!=0";
		
		if ( isset($_POST['customerName'])) 
		{
			$sql .= " AND delivery_orders_details_temp.customerName LIKE '%" . $_POST['customerName'] . "%'";
		}
		
		$sql .= " ORDER BY inputDate desc";
		
        $builder = $this->db->query($sql);
        return $builder;
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
