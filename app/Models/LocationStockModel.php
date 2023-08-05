<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationStockModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'location_stock';
    protected $primaryKey       = 'locationStockId';
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
		// $sql = "SELECT locations.locationName, IFNULL(location_stock.stockPhy, 0) as stockPhy, IFNULL(location_stock.stockAcc, 0) as stockAcc, location_stock.remark FROM location_stock
		// INNER JOIN locations ON locations.locationId=location_stock.locationId";
		// $sql .= " WHERE location_stock.statusId!=0";
		
		$sql = "SELECT products.statusId, products.productId, products.productNumber, products.productName, locations.locationId, locations.locationName, locations.remark, IFNULL(location_stock.stockPhy, 0) as stockPhy, IFNULL(location_stock.stockAcc, 0) as stockAcc FROM locations
		
		LEFT JOIN location_stock ON (location_stock.locationId=locations.locationId";
		
		if ( isset($_GET['productId'])) 
		{
			$sql .= " AND location_stock.productId=" . $_GET['productId'] . ")";
		} else
		if (  isset($_GET['locationId']) ){
			$sql .= " AND location_stock.locationId=" . $_GET['locationId'] . ")";
		}
		
		$sql .= "LEFT JOIN products ON products.productId=location_stock.productId";
		$sql .= " WHERE locations.statusId!=0";
		// $sql .= " AND products.statusId=1"; // hanya yang status product nya aktif
		// $sql .= " AND (stockPhy!=0 OR stockAcc!=0)"; // tidak termasuk yang stock nya 0
		
		if ( $pagination != "" ) {
			
			$rows 	= $pagination["rows"];
			$sort	= $pagination["sort"];
			$order	= $pagination["order"];
			$offset = $pagination["offset"];
			$sql .= " ORDER BY $sort $order limit $offset,$rows";
		}
		
		// log_message('error', $sql);
        $builder = $this->db->query($sql);
        return $builder;
    }
	
	public function getStockPhy($locationId, $productId)
    {
		$sql = "SELECT IFNULL(location_stock.stockPhy, 0) as stockPhy FROM location_stock
		WHERE `locationId`='" . $locationId . "'
		AND `productId`='" . $productId . "'";
		
		$builder = $this->db->query($sql);
		if ($builder->getRow() == null){
			return "0";
		} else {
			return $builder->getRow()->stockPhy;
		}
    }
	
	public function moveStock($source, $destination, $productId, $stock)
    {
		if (empty($source)) {
            throw new \Exception("moveStock `source` empty");
        }
		if (empty($destination)) {
            throw new \Exception("moveStock `destination` empty");
        }
		if (empty($productId)) {
            throw new \Exception("moveStock `productId` empty");
        }
		if (empty($stock)) {
            throw new \Exception("moveStock `stock` empty");
        }
		
		// source = - stock
		$getSelectSource = $this->db->query("INSERT INTO `location_stock`
		(locationId, productId, stockPhy, stockAcc, statusId) 
		values(" . $source . ", " . $productId . ", " . $stock . ", " . $stock . ", 1)
		ON DUPLICATE KEY UPDATE `stockPhy` = (`stockPhy`-" . $stock . "), `stockAcc` = (`stockAcc`-" . $stock . ")");
		
		// destination = + stock
		$getSelectDestination = $this->db->query("INSERT INTO `location_stock`
		(locationId, productId, stockPhy, stockAcc, statusId) 
		values(" . $destination . ", " . $productId . ", " . $stock . ", " . $stock . ", 1)
		ON DUPLICATE KEY UPDATE `stockPhy` = (`stockPhy`+" . $stock . "), `stockAcc` = (`stockAcc`+" . $stock . ")");
		
		return;
    }
	
	protected function callAfterDelete(array $data)
    {
		if (! isset($data['id']['0'])) {
            return $data;
        }
		
		$locationId = addslashes($data['id']['0']); // userId
		
        $sql = "UPDATE `locations` SET `statusId`=0, `deleteBy`='".session()->get('userId')."' WHERE `locationId`='".$locationId."';";

        $builder = $this->db->query($sql);
		
		return $data;
    }
	
}
