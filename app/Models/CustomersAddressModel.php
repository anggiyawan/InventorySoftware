<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomersAddressModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'customers_address';
    protected $primaryKey       = 'customersAddressId';
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
    protected $afterDelete    = ['callAfterDelete'];
	
	protected function callAfterDelete(array $data)
    {
		if (! isset($data['id']['0'])) {
            return $data;
        }
		
		$customerId = addslashes($data['id']['0']); // customerId
		// var_dump($data); exit;
        $sql = "UPDATE `customers_address` SET `statusId`=0, `deleteBy`='".session()->get('userId')."' WHERE `customerId`='".$customerId."';";
		
        $builder = $this->db->query($sql);
		
		 // log_message("info", "Running method after delete". json_encode($data));
		return $data;
    }
}
