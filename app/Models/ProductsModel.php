<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'products';
    protected $primaryKey       = 'productId';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = ['productId', 'inputBy', 'updateBy', 'deleteBy', 'inputDate', 'updateDate', 'deleteDate'];

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
    protected $afterDelete    = ['callAfterDelete'];
	
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
		$sql = "SELECT products_stock.* FROM products_stock";
		$sql .= " WHERE products_stock.statusId!=0";
		if ( !empty($_POST['productId'])) 
		{
			$sql .= " AND products_stock.productId LIKE '%" . $_POST['productId'] . "%'";
		}
		
		if ( !empty($_POST['productNumber'])) 
		{
			$sql .= " AND products_stock.productNumber LIKE '%" . $_POST['productNumber'] . "%'";
		}
		
		if ( !empty($_POST['productName'])) 
		{
			$sql .= " AND products_stock.productName LIKE '%" . $_POST['productName'] . "%'";
		}
		
		if ( !empty($_POST['unit'])) 
		{
			$sql .= " AND products_stock.unit LIKE '%" . $_POST['unit'] . "%'";
		}
		
		if ( !empty($_POST['status'])) 
		{
			$sql .= " AND products_stock.statusId='" . $_POST['status'] . "'";
		}
		
		if ( !empty($_POST['productType'])) 
		{
			$sql .= " AND products_stock.productType='" . $_POST['productType'] . "'";
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
	
	protected function callAfterDelete(array $data)
    {
		if (! isset($data['id']['0'])) {
            return $data;
        }
		
		$productId = addslashes($data['id']['0']); // productId
		
        $sql = "UPDATE `products` SET `statusId`=0, `deleteBy`='".session()->get('userId')."' WHERE `productId`='".$productId."';";

        $builder = $this->db->query($sql);
		
		return $data;
    }
	
}
