<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Combogrid extends BaseController
{
    public function index()
    {
        //
    }
	
	public function combogridPaymentTerms()
	{
		// get table
		$paymentTerms = new \App\Models\PaymentTermsModel();
		$row = array();
		
		$result = array();
		$result['total'] = $paymentTerms->where('statusId!=', 0)->countAllResults();
		$row = array();
		$criteria = $paymentTerms->where('statusId!=', 0)->findAll();
		
		foreach($criteria as $data)
		{	
			$row[] = array(
				'paymentTermId'	=> $data->paymentTermId,
				'termName'		=> $data->termName,
				'selected'		=> true,
			);
			
			// $row['selected'] = true;
			// if ($data->paymentTermId == 1){
				// $test = array(
					// 'selected'		=> true,
				// );
				// $row=array_merge($row,$test);
			// }
		}
		
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	public function combogridSalesOrderToPackage()
	{
		$this->db		= \Config\Database::connect();
		$this->request	= \Config\Services::request();
		
		// get table
		$salesOrdersModel = new \App\Models\SalesOrdersModel();
		$row = array();
		
		$search = @$this->request->getPostGet('q');
		
		$sql = "SELECT salesOrderId, customerName, salesOrderNumber, salesOrderNumber, expectedShipmentDate FROM sales_orders";
		
		$sql .= " WHERE statusId=" . \SALES_ORDER_STATUS::CONFIRM;
		
		if ( !empty($search) ) {
			// $sql .= " AND customerName LIKE '%" . $search . "%'";
			$sql .= " AND salesOrderNumber LIKE '%" . $search . "%'";
		}
		
		$sql .= " limit 50";
		// $result = array();
		// $result['total'] = $salesOrdersModel->where('statusId!=', 0)->countAllResults();
		$result = array();
		$row = array();
		$criteria = $this->db->query($sql);
		$result['total'] = $criteria->getNumRows();
		
		foreach($criteria->getResult() as $data)
		{	
			$row[] = array(
				'salesOrderId'		=> $data->salesOrderId,
				'customerName'		=> $data->customerName,
				'salesOrderNumber'	=> $data->salesOrderNumber,
				'expectedShipment'	=> $data->expectedShipmentDate,
			);
		}
		
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	public function combogridSalesOrderToDelivery()
	{
		$this->db		= \Config\Database::connect();
		$this->request	= \Config\Services::request();
		
		// get table
		$salesOrdersModel = new \App\Models\SalesOrdersModel();
		$row = array();
		
		$search = @$this->request->getPostGet('q');
		
		$sql = "SELECT salesOrderId, customerName, salesOrderNumber, salesOrderNumber, expectedShipmentDate FROM sales_orders";
		
		$sql .= " WHERE statusId=" . \SALES_ORDER_STATUS::CONFIRM;
		
		if ( !empty($search) ) {
			// $sql .= " AND customerName LIKE '%" . $search . "%'";
			$sql .= " AND salesOrderNumber LIKE '%" . $search . "%'";
		}
		
		$sql .= " limit 50";
		$result = array();
		$row = array();
		$criteria = $this->db->query($sql);
		// $result['total'] = $criteria->getNumRows();
		
		foreach($criteria->getResult() as $data)
		{	
			$row[] = array(
				'salesOrderId'		=> $data->salesOrderId,
				'customerName'		=> $data->customerName,
				'salesOrderNumber'	=> $data->salesOrderNumber,
				'expectedShipment'	=> date('Y-m-d', strtotime($data->expectedShipmentDate)),
			);
		}
		
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	public function combogridProductsToPackage()
	{
		$this->db		= \Config\Database::connect();
		$this->request	= \Config\Services::request();
	
		$salesOrdersDetailsModel = new \App\Models\SalesOrdersDetailsModel();
		
		// $locationName = @$_POST['q'];
		$salesOrderId = @$this->request->getGet('salesOrderId');
		
		$sql = "SELECT sales_orders_details.salesOrderDetailId, sales_orders.salesOrderNumber, 
		sales_orders_details.quantity, 
		sales_orders_details.productId, 
		products.productNumber, products.productName FROM sales_orders_details
		INNER JOIN sales_orders ON sales_orders.salesOrderId=sales_orders_details.salesOrderId
		INNER JOIN products ON products.productId=sales_orders_details.productId";
		
		$sql .= " WHERE sales_orders.statusId=" . \SALES_ORDER_STATUS::CONFIRM;
		
		if ( !empty($salesOrderId) ) {
			$sql .= " AND sales_orders_details.salesOrderId=" . $salesOrderId . "";
		}
		
		$sql .= " limit 50";
		
		$result = array();
		$row = array();
		$criteria = $this->db->query($sql);
		$result['total'] = $criteria->getNumRows();
		
		foreach($criteria->getResult() as $data)
		{	
			$row[] = array(
				'productId'				=> $data->productId,
				'productNumber'			=> $data->productNumber,
				'productName'			=> $data->productName,
				'salesOrderDetailId'	=> $data->salesOrderDetailId,
				'salesOrderNumber'		=> $data->salesOrderNumber,
				'quantity'				=> $data->quantity,
				'package'				=> $salesOrdersDetailsModel->getPacked($data->salesOrderDetailId)
			);
		}
		
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	public function combogridProductsToShipment($action = "")
	{
		$this->db		= \Config\Database::connect();
		$this->request	= \Config\Services::request();
	
		$salesOrdersDetailsModel = new \App\Models\SalesOrdersDetailsModel();
		$deliveryOrdersDetailsModel = new \App\Models\DeliveryOrdersDetailsModel();
		$deliveryOrdersDetailsTempModel = new \App\Models\DeliveryOrdersDetailsTempModel();
		
		// $locationName = @$_POST['q'];
		$salesOrderId			= @$this->request->getGet('salesOrderId');
		$deliveryOrderDetailId	= @$this->request->getGet('deliveryOrderDetailId');
		$sourceLocationId		= @$this->request->getGet('sourceLocationId');
		
		if ( $action == "create" ) {
			// log_message('error', $deliveryOrderDetailId);
			$getDeliveryOrder = $deliveryOrdersDetailsTempModel->select('productId')->where(array('deliveryOrderDetailId' => @$deliveryOrderDetailId))->first();
			// JOIN delivery_orders_details_temp
			$sql = "SELECT sales_orders_details.salesOrderDetailId, sales_orders.salesOrderNumber, 
				sales_orders_details.quantity, 
				sales_orders_details.productId, 
				products.productNumber, products.productName, products.unit,
				IFNULL(location_stock.stockPhy, 0) as stockPhy, IFNULL(location_stock.stockAcc,0) as stockAcc
				FROM sales_orders_details
				INNER JOIN sales_orders ON sales_orders.salesOrderId=sales_orders_details.salesOrderId
				INNER JOIN products ON products.productId=sales_orders_details.productId
				LEFT JOIN location_stock ON (products.productId=location_stock.productId AND location_stock.locationId='" . $sourceLocationId . "')
				LEFT JOIN delivery_orders_details_temp ON products.productId=delivery_orders_details_temp.productId AND delivery_orders_details_temp.inputBy='" . session()->get("userId") . "'
				WHERE (delivery_orders_details_temp.productId is Null OR delivery_orders_details_temp.productId='" . @$getDeliveryOrder->productId . "')";
		} else {
			$getDeliveryOrder = $deliveryOrdersDetailsModel->select('productId')->where(array('deliveryOrderDetailId' => @$deliveryOrderDetailId))->first();
			// JOIN delivery_orders_details
			$sql = "SELECT sales_orders_details.salesOrderDetailId, sales_orders.salesOrderNumber, 
				sales_orders_details.quantity, 
				sales_orders_details.productId, 
				products.productNumber, products.productName, products.unit,
				IFNULL(location_stock.stockPhy, 0), IFNULL(location_stock.stockAcc,0)
				FROM sales_orders_details
				INNER JOIN sales_orders ON sales_orders.salesOrderId=sales_orders_details.salesOrderId
				INNER JOIN products ON products.productId=sales_orders_details.productId
				LEFT JOIN location_stock ON (products.productId=location_stock.productId AND location_stock.locationId='" . $sourceLocationId . "')
				LEFT JOIN delivery_orders_details ON products.productId=delivery_orders_details.productId AND delivery_orders_details.deliveryOrderId='" . $action . "'
				WHERE (delivery_orders_details.productId is Null OR delivery_orders_details.productId='" . @$getDeliveryOrder->productId . "')";
		}
		
		$sql .= " AND sales_orders.statusId=" . \SALES_ORDER_STATUS::CONFIRM;
		
		if ( !empty($salesOrderId) ) {
			$sql .= " AND sales_orders_details.salesOrderId=" . $salesOrderId . "";
		}
		
		// $sql .= " limit 50";
		
		$result = array();
		$row = array();
		$criteria = $this->db->query($sql);
		$result['total'] = $criteria->getNumRows();
		
		foreach($criteria->getResult() as $data)
		{
			$getDelivered = $salesOrdersDetailsModel->getDelivered($data->salesOrderDetailId, $data->productId, $deliveryOrderDetailId);
			if ($getDelivered < $data->quantity) {
				$row[] = array(
					'productId'				=> $data->productId,
					'productNumber'			=> $data->productNumber,
					'productName'			=> $data->productName,
					'salesOrderDetailId'	=> $data->salesOrderDetailId,
					'salesOrderNumber'		=> $data->salesOrderNumber,
					'quantity'				=> $data->quantity,
					'stockPhy'				=> $data->stockPhy . " " . $data->unit,
					'stockAcc'				=> $data->stockAcc . " " . $data->unit,
					'delivered'				=> $getDelivered,
				);
			}
		}
		
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	public function combogridRepresentative()
	{
		// get table
		$representative = new \App\Models\RepresentativesModel();
		$row = array();
		
		$result = array();
		$result['total'] = $representative->where('statusId', 1)->countAllResults();
		$row = array();
		$criteria = $representative->where('statusId=', 1)->findAll();
		
		// if ( $param == "all" ) {
			$row[] = array(
					'representativeId'	=> '0',
					'representative'	=> '--',
					'description'		=> '--',
				);
		// }
		
		foreach($criteria as $data)
		{	
			$row[] = array(
				'representativeId'	=> $data->representativeId,
				'representative'	=> $data->representative,
				'description'		=> $data->description,
			);
		}
		
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	public function combogridCustomerStatus($param = "")
	{
		// get table
		$customersStatus = new \App\Models\CustomersStatusModel();
		$row = array();
		
		$result = array();
		// $result['total'] = $customersStatus->countAllResults();
		$row = array();
		$criteria = $customersStatus->orderBy('orderBy', 'asc')->findAll();
		
		if ( $param == "all" ) {
			$row[] = array(
					'id'		=> '',
					'name'		=> 'ALL',
				);
		}
		
		foreach($criteria as $data)
		{	
			$row[] = array(
				'id'		=> $data->customerStatusId,
				'name'		=> $data->customerStatusName,
			);
			
		}
		
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	public function combogridLocations()
	{
		$this->db		= \Config\Database::connect();
		$this->request	= \Config\Services::request();
	
		// $locationName = @$_POST['q'];
		$locationName = @$this->request->getPostGet('q');
		
		$sql = "SELECT locationId, locationName, remark FROM locations";
		
		$sql .= " WHERE statusId='1'";
		
		if ( !empty($locationName) ) {
			$sql .= " AND locationName LIKE '%" . $locationName . "%'";
		}
		
		$sql .= " limit 50";
		
		$result = array();
		$row = array();
		$criteria = $this->db->query($sql);
		$result['total'] = $criteria->getNumRows();
		
		foreach($criteria->getResult() as $data)
		{	
			$row[] = array(
				'locationId'	=> $data->locationId,
				'locationName'	=> $data->locationName,
				'remark'		=> $data->remark,
			);
		}
		
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	public function combogridCustomer()
	{
		$this->db		= \Config\Database::connect();
		$this->request	= \Config\Services::request();
	
		// $locationName = @$_POST['q'];
		$customerName = @$this->request->getPostGet('q');
		
		$sql = "SELECT customers.customerId, customers.customerName,
		billAddress.customerAddressId as billId,
		billAddress.country as billCountry,
		billAddress.address1 as billAddress1,
		billAddress.address2 as billAddress2,
		billAddress.city as billCity,
		billAddress.state as billState,
		billAddress.zipCode as billZipCode,
		billAddress.Phone as billPhone,
		billAddress.Fax as billFax,
		
		shipAddress.customerAddressId as shipId,
		shipAddress.country as shipCountry,
		shipAddress.address1 as shipAddress1,
		shipAddress.address2 as shipAddress2,
		shipAddress.city as shipCity,
		shipAddress.state as shipState,
		shipAddress.zipCode as shipZipCode,
		shipAddress.Phone as shipPhone,
		shipAddress.Fax as shipFax,
		
		customers.paymentTermId
		
		FROM customers
		LEFT JOIN customers_address as billAddress ON (customers.customerId=billAddress.customerId AND billAddress.customerAddressTypeId=1)
		LEFT JOIN customers_address as shipAddress ON (customers.customerId=shipAddress.customerId AND shipAddress.customerAddressTypeId=2)
		WHERE customers.statusId=" . \CUSTOMERS::ACTIVE;
		
		// $sql .= " AND statusId='1'";
		
		if ( !empty($customerName) ) {
			$sql .= " AND customers.customerName LIKE '%" . $customerName . "%'";
		}
		
		$sql .= " limit 50";
		
		$result = array();
		$row = array();
		$criteria = $this->db->query($sql);
		$result['total'] = $criteria->getNumRows();
		
		foreach($criteria->getResult() as $data)
		{	
			$row[] = array(
				'customerId'	=> $data->customerId,
				'customerName'	=> $data->customerName,
				
				'billId'		=> $data->billId,
				'billAddress1'	=> $data->billAddress1,
				'billAddress2'	=> $data->billAddress2,
				'billCity'		=> $data->billCity,
				'billState'		=> $data->billState,
				'billZipCode'	=> $data->billZipCode,
				'billPhone'		=> $data->billPhone,
				'billFax'		=> $data->billFax,
				
				'shipId'		=> $data->shipId,
				'shipAddress1'	=> $data->shipAddress1,
				'shipAddress2'	=> $data->shipAddress2,
				'shipCity'		=> $data->shipCity,
				'shipState'		=> $data->shipState,
				'shipZipCode'	=> $data->shipZipCode,
				'shipPhone'		=> $data->shipPhone,
				'shipFax'		=> $data->shipFax,
				'paymentTermId'	=> $data->paymentTermId,
			);
		}
		
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	public function combogridUnit()
	{
		$this->db		= \Config\Database::connect();
		$this->request	= \Config\Services::request();
		
		$getUnit = \UNIT::getAllConsts();
	
		// $locationName = @$_POST['q'];
		// $locationName = @$this->request->getPostGet('q');
		
		// $sql = "SELECT locationId, locationName FROM location";
		
		// $sql .= " WHERE statusId='1'";
		
		// if ( !empty($locationName) ) {
			// $sql .= " AND locationName LIKE '%" . $locationName . "%'";
		// }
		
		// $sql .= " limit 50";
		
		// $result = array();
		// $row = array();
		// $criteria = $this->db->query($sql);
		// $result['total'] = $criteria->getNumRows();
		
		foreach($getUnit as $data)
		{	
			// var_dump($data);
			$row[] = array(
				'id'	=> $data,
				'name'	=> $data,
			);
		}
		
		// $result=array_merge($result,array('rows'=>$row));
		return json_encode($row);
	}
	
	public function combogridProductType($param = "")
	{
		$getUnit = \PRODUCTS_TYPE::getAllConsts();
		
		if ( $param == "all" ) {
			$row[] = array(
					'id'		=> '',
					'name'		=> 'All',
				);
		}
		
		foreach(array_change_key_case($getUnit,CASE_LOWER) as $key => $data)
		{
			$row[] = array(
				'id'	=> $data,
				'name'	=> ucfirst((string)$key),
			);
		}
		
		return json_encode($row);
	}
	
	public function combogridSalesOrderStatus($param)
	{
		$getUnit = \SALES_ORDER_STATUS::getAllConsts();
		
		if ( $param == "all" ) {
			$row[] = array(
					'id'		=> '',
					'name'		=> 'All',
				);
		}
		
		foreach(array_change_key_case($getUnit,CASE_LOWER) as $key => $data)
		{
			$row[] = array(
				'id'	=> $data,
				'name'	=> ucfirst((string)$key),
			);
		}
		
		return json_encode($row);
	}
	
	public function combogridDeliveryOrderStatus($param)
	{
		$getUnit = \DELIVERY_ORDER_STATUS::getAllConsts();
		
		if ( $param == "all" ) {
			$row[] = array(
					'id'		=> '',
					'name'		=> 'All',
				);
		}
		
		foreach(array_change_key_case($getUnit,CASE_LOWER) as $key => $data)
		{
			$row[] = array(
				'id'	=> $data,
				'name'	=> ucfirst((string)$key),
			);
		}
		
		return json_encode($row);
	}
	
	public function combogridProducts()
	{
		$this->db		= \Config\Database::connect();
		$this->request	= \Config\Services::request();
	
		// $locationName = @$_POST['q'];
		$productName = @$this->request->getPostGet('q');
		
		$sql = "SELECT productId, productNumber, productName, priceSell, unit, stockPhyHand FROM products";
		
		$sql .= " WHERE statusId='1'";
		
		if ( !empty($productName) ) {
			$sql .= " AND productName LIKE '%" . $productName . "%'";
		}
		
		$sql .= " limit 50";
		
		$result = array();
		$row = array();
		$criteria = $this->db->query($sql);
		$result['total'] = $criteria->getNumRows();
		
		foreach($criteria->getResult() as $data)
		{	
			$row[] = array(
				'productId'		=> $data->productId,
				'productNumber'	=> $data->productNumber,
				'productName'	=> $data->productName,
				'unit'			=> $data->unit,
				'priceSell'		=> $data->priceSell,
				'stockPhyHand'	=> $data->stockPhyHand,
			);
		}
		
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	public function combogridProductsSalesOrdersDetails($action = "")
	{
		// helper
		Helper('web');
		
		$this->db		= \Config\Database::connect();
		$this->request	= \Config\Services::request();
		$this->session	= \Config\Services::session();
	
		// $locationName = @$_POST['q'];
		$productName = @$this->request->getPostGet('q');
		
		/*
		if ( $action == "create" ) {
			// get join from `sales_orders_details_temp`
			$sql = "SELECT products.productId, products.productNumber, products.productName, products.priceSell, products.unit, sales_orders_details_temp.inputBy FROM products
			LEFT JOIN sales_orders_details_temp ON products.productId=sales_orders_details_temp.productId AND sales_orders_details_temp.inputBy='" . session()->get("userId") . "'
			WHERE sales_orders_details_temp.productId is Null";
		} else {
			// get join from `sales_orders_details`
			$sql = "SELECT products.productId, products.productNumber, products.productName, products.priceSell, products.unit, sales_orders_details.inputBy FROM products
			LEFT JOIN sales_orders_details ON products.productId=sales_orders_details.productId AND sales_orders_details.salesOrderId='" . $action . "'
			WHERE sales_orders_details.productId is Null";
		}
		*/
		
		$sql = "SELECT products.productId, products.productNumber, products.productName, products.priceSell, products.unit FROM products";
		$sql .= " WHERE products.statusId='1'";
		
		if ( !empty($productName) ) {
			$sql .= " AND (products.productNumber LIKE '%" . $productName . "%'";
			$sql .= " OR products.productName LIKE '%" . $productName . "%')";
		}
		
		// $sql .= " limit 50";
		
		$result = array();
		$row = array();
		$criteria = $this->db->query($sql);
		$result['total'] = $criteria->getNumRows();
		
		foreach($criteria->getResult() as $data)
		{	
			$row[] = array(
				'productId'		=> $data->productId,
				'productNumber'	=> $data->productNumber,
				'productName'	=> $data->productName,
				'unit'			=> $data->unit,
				'priceSell'		=> $data->priceSell,
				'amount'		=> \FormatCurrency($data->priceSell),
			);
		}
		
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	public function combogridProductsByStockLocation()
	{
		$this->db		= \Config\Database::connect();
		$this->request	= \Config\Services::request();
	
		// $locationName = @$_POST['q'];
		$productName = @$this->request->getPostGet('q');
		
		$sql = "SELECT products_stock.productId, products_stock.productNumber, products_stock.productName, products_stock.priceSell, products_stock.unit, products_stock.stockPhyHand, 
			IFNULL(source.stockPhy, 0) as sourceStock,
			IFNULL(destination.stockPhy, 0) as destinationStock
			FROM products_stock
			LEFT JOIN location_stock as source ON (products_stock.productId=source.productId AND source.locationId=" . @$this->request->getGet('source') . ")
			LEFT JOIN location_stock as destination ON (products_stock.productId=destination.productId AND destination.locationId=" . @$this->request->getGet('destination') . ")";
		
		$sql .= " WHERE products_stock.statusId='1'";
		// log_message('error', $sql);
		if ( $productName != '' ) {
			$sql .= " AND products_stock.productName LIKE '%lap%'";
		}
		
		$sql .= " limit 50";
		
		$result = array();
		$row = array();
		$criteria = $this->db->query($sql);
		$result['total'] = $criteria->getNumRows();
		
		foreach($criteria->getResult() as $data)
		{	
			$row[] = array(
				'productId'			=> $data->productId,
				'productNumber'		=> $data->productNumber,
				'productName'		=> $data->productName,
				'unit'				=> $data->unit,
				'priceSell'			=> $data->priceSell,
				'stockPhyHand'		=> $data->stockPhyHand,
				'sourceStock'		=> $data->sourceStock,
				'destinationStock'	=> $data->destinationStock,
			);
		}
		
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
}
