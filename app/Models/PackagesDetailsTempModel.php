<?php

namespace App\Models;

use CodeIgniter\Model;

class PackagesDetailsTempModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'packages_details_temp';
    protected $primaryKey       = 'packageDetailId';
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
		$sql = "SELECT packages_details_temp.packageDetailId, packages_details_temp.salesOrderDetailId, packages_details_temp.quantityToPack, packages_details_temp.ordered, products.productId, products.productName, products.productNumber FROM packages_details_temp
		INNER JOIN products ON products.productId=packages_details_temp.productId";
		$sql .= " WHERE packages_details_temp.inputBy!=''";
		$sql .= " AND packages_details_temp.inputBy='" . session()->get("userId") . "'";
		
		if ( isset($_POST['productId'])) 
		{
			$sql .= " AND packages_details_temp.productId LIKE '%" . $_POST['productId'] . "%'";
		}
		
		// if ( isset($_POST['remark'])) 
		// {
			// $sql .= " AND packages_details_temp.remark LIKE '%" . $_POST['remark'] . "%'";
		// }
		
		// if ( $_POST['statusId'] != null) 
		// {
			// $sql .= " AND packages_details_temp.statusId='" . $_POST['statusId'] . "'";
		// }
		
		$sql .= " ORDER BY packages_details_temp.inputDate desc";
		
        $builder = $this->db->query($sql);
        return $builder;
    }
	
	// public function autoPackageNumber()
	// {
		// $configName = \AUTONUMBER::PACKING_SLIP;
		// $builder = $this->db->query("SELECT prefix, max(RIGHT(number, 6)) as numberId FROM `auto_number` WHERE `configName`='" . $configName . "'");
		
		// $numberIncrement = 1 + $builder->getRow()->numberId;
		// $NumberSprint = "" . sprintf("%06s", $numberIncrement) ;
		// return $builder->getRow()->prefix . $NumberSprint;
	// }
	
}
