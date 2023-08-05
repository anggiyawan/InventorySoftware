<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesOrdersDetailsTempModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sales_orders_details_temp';
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
    protected $updatedField  = '';
    protected $deletedField  = '';

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
		$this->request	= \Config\Services::request();
		
		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'salesOrderDetailId';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'desc';
		$offset = ($page-1) * $rows;
		
		$sql = "SELECT sales_orders_details_temp.* FROM sales_orders_details_temp";
		$sql .= " WHERE sales_orders_details_temp.statusId!=0";
		$sql .= " AND sales_orders_details_temp.inputBy='" . session()->get("userId") . "'";
		
		// if ( isset($_POST['userName'])) 
		// {
			// $sql .= " AND sales_orders_details_temp.userName LIKE '%" . $_POST['userName'] . "%'";
		// }
		
		// if ( isset($_POST['groupId'])) 
		// {
			// $sql .= " AND sales_orders_details_temp.groupId LIKE '%" . $_POST['groupId'] . "%'";
		// }
		
		$sql .= " ORDER BY $sort $order limit $offset,$rows";
		
        $builder = $this->db->query($sql);
        return $builder;
    }
	
	/*
	protected function callAfterDelete(array $data)
    {
		if (! isset($data['id']['0'])) {
            return $data;
        }
		
		$salesOrderDetailId = addslashes($data['id']['0']); // salesOrderDetailId
		// var_dump($data); exit;
        $sql = "UPDATE `sales_orders_details_temp` SET `statusId`=0, `deleteBy`='".session()->get('userId')."' WHERE `salesOrderDetailId`='".$salesOrderDetailId."';";

        $builder = $this->db->query($sql);
		
		// log_message("info", "Running method after delete". json_encode($data));
		return $data;
    }
	*/
	
}
