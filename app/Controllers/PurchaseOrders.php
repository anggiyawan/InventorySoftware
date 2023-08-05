<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PurchaseOrders extends BaseController
{
	public function __construct()
	{
		$this->db		= \Config\Database::connect();
		// $this->request	= \Config\Services::request();
		$this->session	= \Config\Services::session();
		$this->validation =  \Config\Services::validation();
	}
	
    public function index()
    {
        //
    }
	
	public function manage()
    {
        return view('purchaseOrders/purchaseOrders');
    }
	
	public function formPurchaseOrders($action = "")
    {
		// get model table
		$salesOrdersModel		= new \App\Models\SalesOrdersModel();
		$salesOrdersAmountModel	= new \App\Models\SalesOrdersAmountModel();
		
		if ($action == "create") {
			$salesOrdersDetailsTempModel	= new \App\Models\SalesOrdersDetailsTempModel();
			$salesOrdersDetailsTempModel->where('inputBy', session()->get('userId'))->delete();
			
			$data['urlDatagrid'] = base_url('salesorders/getJsonDetailsTemp');
		} else {
			$getSalesOrder	= $salesOrdersModel->where(array('salesOrderId' => $action, 'statusId' => \SALES_ORDER_STATUS::DRAFT))->first();
			if($getSalesOrder == null){
				return("sales orders status not is draft");
			}
			
			// for update salesOrders
			$salesOrdersAddressModel 		= new \App\Models\SalesOrdersAddressModel();
			$getCustomerBillAddress		= $salesOrdersAddressModel->where(array('salesOrderId' => $action, 'statusId' => 1, 'customerAddressTypeId'	=> \CUSTOMER_ADDRESS_TYPE::BILLING_ADDRESS))->first();
			$getCustomerShipAddress		= $salesOrdersAddressModel->where(array('salesOrderId' => $action, 'statusId' => 1, 'customerAddressTypeId'	=> \CUSTOMER_ADDRESS_TYPE::SHIPPING_ADDRESS))->first();
			
			$data = array(
				'billCountry'			=> $getCustomerBillAddress->country,
				'billAddress1'			=> $getCustomerBillAddress->address1,
				'billAddress2'			=> $getCustomerBillAddress->address2,
				'billCity'				=> $getCustomerBillAddress->city,
				'billState'				=> $getCustomerBillAddress->state,
				'billZipCode'			=> $getCustomerBillAddress->zipCode,
				'billPhone'				=> $getCustomerBillAddress->phone,
				'billFax'				=> $getCustomerBillAddress->fax,
				
				'shipCountry'			=> $getCustomerShipAddress->country,
				'shipAddress1'			=> $getCustomerShipAddress->address1,
				'shipAddress2'			=> $getCustomerShipAddress->address2,
				'shipCity'				=> $getCustomerShipAddress->city,
				'shipState'				=> $getCustomerShipAddress->state,
				'shipZipCode'			=> $getCustomerShipAddress->zipCode,
				'shipPhone'				=> $getCustomerShipAddress->phone,
				'shipFax'				=> $getCustomerShipAddress->fax
			);
			$data['urlDatagrid'] = base_url('salesorders/getJsonDetails?salesOrderId=' . $action);
		}
		
		$salesOrdersAmount	= array();
		$salesAmount		= $salesOrdersAmountModel->where(array('salesOrderId' => $action, 'statusId' => 1))->findAll();
		foreach($salesAmount as $amountDetail)
		{	
			$salesOrdersAmount[$amountDetail->name] = $amountDetail->value;			
		}
		// echo var_dump($salesOrdersAmount["sub_total"]);
		// exit;
		$data['salesAmount']		= $salesOrdersAmount;
		$data['action']				= $action;
		$data['salesOrderNumber']	= $salesOrdersModel->autoSalesOrderNumber();
		
		return view("purchaseOrders/addPurchaseOrders", $data);
	}
}
