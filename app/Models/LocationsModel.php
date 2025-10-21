<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'locations';
    protected $primaryKey       = 'locationId';
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

    // Listing Join
    public function getData($pagination = "")
    {
        $sql = "SELECT locations.* FROM locations";
        $sql .= " WHERE locations.statusId!=0";

        if (isset($_POST['locationName'])) {
            $sql .= " AND locations.locationName LIKE '%" . $_POST['locationName'] . "%'";
        }

        if (isset($_POST['remark'])) {
            $sql .= " AND locations.remark LIKE '%" . $_POST['remark'] . "%'";
        }

        if (isset($_POST['statusId'])) {
            $sql .= " AND locations.statusId='" . $_POST['statusId'] . "'";
        }

        if ($pagination != "") {

            $rows     = $pagination["rows"];
            $sort    = $pagination["sort"];
            $order    = $pagination["order"];
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

        $locationId = addslashes($data['id']['0']); // userId

        $sql = "UPDATE `locations` SET `statusId`=0, `deleteBy`='" . session()->get('userId') . "' WHERE `locationId`='" . $locationId . "';";

        $builder = $this->db->query($sql);

        return $data;
    }

    public function adjustmentStockPhy($locationId, $productId, $quantity)
    {
        if (empty($locationId)) {
            throw new \Exception("adjustment `locationId` empty");
        }
        if (empty($productId)) {
            throw new \Exception("adjustment `productId` empty");
        }
        if (empty($quantity)) {
            throw new \Exception("adjustment `quantity` empty");
        }

        $sql = "INSERT INTO `location_stock`
		(locationId, productId, stockPhy, statusId) 
		values(" . $locationId . ", " . $productId . ", " . $quantity . ", 1)
		ON DUPLICATE KEY UPDATE `stockPhy` = (`stockPhy`+" . $quantity . ")";

        $this->db->query($sql);

        return;
    }

    public function adjustmentStockAcc($locationId, $productId, $quantity)
    {
        if (empty($locationId)) {
            throw new \Exception("adjustment `locationId` empty");
        }
        if (empty($productId)) {
            throw new \Exception("adjustment `productId` empty");
        }
        if (empty($quantity)) {
            throw new \Exception("adjustment `quantity` empty");
        }

        $sql = "INSERT INTO `location_stock`
		(locationId, productId, stockAcc, statusId) 
		values(" . $locationId . ", " . $productId . ", " . $quantity . ", 1)
		ON DUPLICATE KEY UPDATE `stockAcc` = (`stockAcc`+" . $quantity . ")";

        $builder = $this->db->query($sql);

        return $builder;
    }

    // protected function callAfterInsert(array $data)
    // {
    // if (! isset($data['data']['userId'])) {
    // return $data;
    // }

    // $userId = substr($data['data']['userId'], -6);

    // $sql = "UPDATE `db`.`autoNumber` SET `number`='".$userId."' WHERE `configName`='userId';";

    // $builder = $this->db->query($sql);

    // return $data;
    // }
}
