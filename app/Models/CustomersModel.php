<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'customers';
    protected $primaryKey       = 'customerId';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = ['customerId', 'customerTypeId', 'customerName', 'customerDisplay', 'customerEmail', 'customerPhone', 'customerMobile', 'customerCurrency', 'paymentTermId', 'website', 'statusId', 'remark', 'deleteBy'];

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
    protected function getData($pagination = "")
    {
		$sql = "SELECT customers.*, payment_terms.paymentTermId, payment_terms.termName, 
		billAddress.country as billCountry,
		billAddress.address1 as billAddress1,
		billAddress.address2 as billAddress2,
		billAddress.city as billCity,
		billAddress.state as billState,
		billAddress.zipCode as billZipCode,
		billAddress.Phone as billPhone,
		billAddress.Fax as billFax,
		
		shipAddress.country as shipCountry,
		shipAddress.address1 as shipAddress1,
		shipAddress.address2 as shipAddress2,
		shipAddress.city as shipCity,
		shipAddress.state as shipState,
		shipAddress.zipCode as shipZipCode,
		shipAddress.Phone as shipPhone,
		shipAddress.Fax as shipFax
		
		FROM customers
		LEFT JOIN payment_terms ON customers.paymentTermId=payment_terms.paymentTermId
		LEFT JOIN customers_address as billAddress ON (customers.customerId=billAddress.customerId AND billAddress.customerAddressTypeId=1)
		LEFT JOIN customers_address as shipAddress ON (customers.customerId=shipAddress.customerId AND shipAddress.customerAddressTypeId=2)";
		$sql .= " WHERE customers.statusId!=0";
		
		if ( isset($_POST['customerId'])) 
		{
			$sql .= " AND customers.customerId LIKE '%" . $_POST['customerId'] . "%'";
		}
		
		if ( isset($_POST['customerName'])) 
		{
			$sql .= " AND customers.customerName LIKE '%" . $_POST['customerName'] . "%'";
		}
		
		if ( isset($_POST['customerDisplay'])) 
		{
			$sql .= " AND customers.customerDisplay LIKE '%" . $_POST['customerDisplay'] . "%'";
		}
		
		if ( isset($_POST['customerEmail'])) 
		{
			$sql .= " AND customers.customerEmail LIKE '%" . $_POST['customerEmail'] . "%'";
		}
		
		if ( isset($_POST['customerPhone'])) 
		{
			$sql .= " AND customers.customerPhone LIKE '%" . $_POST['customerPhone'] . "%'";
		}
		
		if ( isset($_POST['customerMobile'])) 
		{
			$sql .= " AND customers.customerMobile LIKE '%" . $_POST['customerMobile'] . "%'";
		}
		
		if ( !empty($_POST['customerStatus'])) 
		{
			$sql .= " AND customers.statusId='" . $_POST['customerStatus'] . "'";
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
	
	// public function autoCustomersId($configName)
	// {
		// $builder = $this->db->query("SELECT prefix, max(RIGHT(number, 6)) as numberId FROM `auto_number` WHERE `configName`='" . $configName . "'");
		
		// $numberIncrement = 1 + $builder->getRow()->numberId;
		// $NumberSprint = "" . sprintf("%06s", $numberIncrement) ;
		// return $builder->getRow()->prefix . $NumberSprint;
	// }
	
	protected function callAfterDelete(array $data)
    {
		if (! isset($data['id']['0'])) {
            return $data;
        }
		
		$customerId = addslashes($data['id']['0']); // customerId
		// var_dump($data); exit;
        $sql = "UPDATE `customers` SET `statusId`=0, `deleteBy`='".session()->get('userId')."' WHERE `customerId`='".$customerId."';";
        // $sql = "UPDATE `customers` SET `statusId`=0, `deleteBy`='100001' WHERE `customerId`='".$data['customerId']."';";

        $builder = $this->db->query($sql);
		
		// log_message("info", "Running method after delete". json_encode($data));
		return $data;
    }
}
