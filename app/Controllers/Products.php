<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Products extends BaseController
{
	public function __construct()
	{
		$this->db		= \Config\Database::connect();
		$this->request	= \Config\Services::request();
		// $this->session	= \Config\Services::session();
		$this->validation =  \Config\Services::validation();
	}
	
    public function index()
    {
        //
    }
	
	public function viewLocationStock()
	{
		return view('products/viewLocationStock');
	}
	
	public function manage()
    {
        return view('products/products');
    }
	
	public function getJson()
    {
		// helper
		Helper('web');
		
		// get model table
		$productsModel = new \App\Models\ProductsModel();

        $page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'productId';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'asc';
		$offset = ($page-1) * $rows;
		
		$result = array();
		$result['total'] = $productsModel->getCount();
		$row = array();
		
		$criteria = $productsModel->getAll(array("sort" => $sort, "order" => $order, "offset" => $offset, "rows" => $rows));
		
		foreach($criteria as $data)
		{	
			if ( $data->statusId == \USERS::ACTIVE ) {
		        $status = "<img src='" . base_url('assets/css/icons/st_green.gif') . "'> Active";
			}
		    else if ( $data->statusId == \USERS::DISABLED ) {
		        $status = "<img src='" . base_url('assets/css/icons/st_red.gif') . "'> Disable";
			}
			
			if ( $data->productType == \PRODUCTS_TYPE::SERVICE ) {
		        $productTypeDesc = "<img width='16px' src='" . base_url('assets/css/icons/service.png') . "'> Service";
			}
		    else if ( $data->productType == \PRODUCTS_TYPE::MATERIAL ) {
		        $productTypeDesc = "<img width='16px' src='" . base_url('assets/css/icons/material.png') . "'> Material";
			}
			else if ( $data->productType == \PRODUCTS_TYPE::GOODS ) {
		        $productTypeDesc = "<img width='16px' src='" . base_url('assets/css/icons/goods.png') . "'> Goods";
			}
			else if ( $data->productType == \PRODUCTS_TYPE::WIP ) {
		        $productTypeDesc = "<img width='16px' src='" . base_url('assets/css/icons/wip.png') . "'> Wip";
			}
			else if ( $data->productType == \PRODUCTS_TYPE::ASSETS ) {
		        $productTypeDesc = "<img width='16px' src='" . base_url('assets/css/icons/assets.png') . "'> Assets";
			}
			
			$row[] = array(
				'productId'			=> $data->productId,
				'productNumber'		=> $data->productNumber,
				'productTypeDesc'	=> $productTypeDesc,
				'productType'		=> $data->productType,
				'productName'		=> $data->productName,
				
				'priceCostCurrency'	=> \FormatCurrency($data->priceCost),
				'priceSellCurrency'	=> \FormatCurrency($data->priceSell),
				'priceCost'			=> ($data->priceCost),
				'priceSell'			=> ($data->priceSell),
				'length'			=> $data->length,
				'width'				=> $data->width,
				'height'			=> $data->height,
				'weight'			=> $data->weight,
				'unit'				=> $data->unit,
				
				'stockAccHand'		=> $data->stockAccHand,
				'stockAccCommit'	=> $data->stockAccCommit,
				'stockAccSale'		=> $data->stockAccSale,
				
				'stockPhyHand'		=> $data->stockPhyHand,
				'stockPhyCommit'	=> $data->stockPhyCommit,
				'stockPhySale'		=> $data->stockPhySale,
				
				'status'			=> $status,
				'statusId'			=> $data->statusId,
				'inputBy'			=> $data->inputBy,
				'inputDate'			=> date('Y-m-d', strtotime($data->inputDate)),
				'updateBy'			=> $data->updateBy,
				'updateDate'		=> date('Y-m-d', strtotime($data->updateDate))
			);
			
		}
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
    }
	
	public function getJsonLocationStock()
    {
		// get model table
		$locationStockModel = new \App\Models\LocationStockModel();

        $page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'productId';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'asc';
		$offset = ($page-1) * $rows;
		
		$result = array();
		$result['total'] = $locationStockModel->getCount();
		$row = array();
		
		$criteria = $locationStockModel->getAll(array("sort" => $sort, "order" => $order, "offset" => $offset, "rows" => $rows));
		
		foreach($criteria as $data)
		{
			$row[] = array(
				'locationId'	=> $data->locationId,
				'locationName'	=> $data->locationName,
				'productId'		=> $data->productId,
				'productName'	=> $data->productName,
				'stockPhy'		=> $data->stockPhy,
				'stockAcc'		=> $data->stockAcc,
				'remark'		=> $data->remark,
			);
			
		}
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
    }
	
	public function updateProducts()
    {
		header('Content-Type: application/json');
		
		// get model table
		$productsModel = new \App\Models\ProductsModel();
		
		try
		{
			if(empty( $this->request->getPostGet() )) {
				throw new \Exception("Data Empty.");
			}
			
			$this->validation->setRules([
                "productName" 	=> ["label" => "*Name*", "rules" => "required|min_length[3]|max_length[255]"],
            ]);
			
			if(!$this->validation->withRequest($this->request)->run()){
				foreach ($this->validation->getErrors() as $error) {}
				throw new \Exception($error);
			}
			
			$productId = addslashes($this->request->getPost("productId"));
			// log_message('error', $this->request->getPost("unit"));
			//update users
			$paramUpdate = array(
				'productId'			=> $productId,
				'productNumber'		=> $this->request->getPost("productNumber"),
				'productName'		=> $this->request->getPost("productName"),
				'productType'		=> $this->request->getPost("productType"),
				'priceCost'			=> $this->request->getPost("priceCost"),
				'priceSell'			=> $this->request->getPost("priceSell"),
				'length'			=> $this->request->getPost("length"),
				'width'				=> $this->request->getPost("width"),
				'height'			=> $this->request->getPost("height"),
				'weight'			=> $this->request->getPost("weight"),
				'unit'				=> $this->request->getPost("unit"),
				'statusId'			=> $this->request->getPost("statusId"),
				'updateBy'			=> session()->get("userId"),
			);
			
			$productsModel->where("productId", $productId);
			$productsModel->set($paramUpdate);
			$productsModel->update();
			
			$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
		}
		catch(\Exception $ex)
		{
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}
		
		echo $returnValue;
    }
	
	public function createProducts()
    {
		header('Content-Type: application/json');
		
		// get model table
		$productsModel		= new \App\Models\ProductsModel();
		$locationStockModel	= new \App\Models\LocationStockModel();
		$locationsModel		= new \App\Models\LocationsModel();
		
		try
		{
			if(empty( $this->request->getPostGet() )) {
				throw new \Exception("Data Empty.");
			}
			
			$this->validation->setRules([
                "productName" 	=> ["label" => "*Name*", "rules" => "required|min_length[3]|max_length[255]"],
                "priceCost" 	=> ["label" => "*Price Cost*", "rules" => "required|min_length[1]|max_length[10]"],
                "priceSell" 	=> ["label" => "*Price Sell*", "rules" => "required|min_length[1]|max_length[10]"],
            ]);
			
			if(!$this->validation->withRequest($this->request)->run()){
				foreach ($this->validation->getErrors() as $error) {}
				throw new \Exception($error);
			}
			
			if ($this->request->getPost("productOpenStock") > 0) {
				if ( empty($this->request->getPost("locationId")) ) {
					throw new \Exception("Location must not be empty");
				}
			}
			
			$getLocations = $locationsModel->where(array('locationId' => $this->request->getPost("locationId"), 'statusId' => 1))->first();
			if($getLocations == null){
				throw new \Exception("Location not valid");
			}
			
			// $getProduct = $productsModel->where(array('productId' => $this->request->getPost("productId"), 'statusId' => 1))->first();
			// if($getProduct == null){
				// throw new \Exception("Product not valid");
			// }
			
			$this->db->transBegin();
				// insert products
				$paramInsert = array(
					'productNumber'		=> $this->request->getPost("productNumber"),
					'productName'		=> $this->request->getPost("productName"),
					'productType'		=> $this->request->getPost("productType"),
					'priceCost'			=> $this->request->getPost("priceCost"),
					'priceSell'			=> $this->request->getPost("priceSell"),
					'length'			=> $this->request->getPost("length"),
					'width'				=> $this->request->getPost("width"),
					'height'			=> $this->request->getPost("height"),
					'weight'			=> $this->request->getPost("weight"),
					'unit'				=> $this->request->getPost("unit"),
					'statusId'			=> $this->request->getPost("statusId"),
					'inputBy'			=> session()->get("userId"),
				);
				
				$insert = $productsModel->insert($paramInsert);
				// insert products EOF
				
				if ( !empty($this->request->getPost("locationId")) ) {
					// insert location_stock
					$paramInsertStock = array(
						'productId'			=> $productsModel->getInsertID(),
						'locationId'		=> $this->request->getPost("locationId"),
						'locationName'		=> $getLocations->locationName,
						'stockPhy'			=> $this->request->getPost("productOpenStock"),
						'stockAcc'			=> $this->request->getPost("productOpenStock"),
						'statusId'			=> 1,
						'inputBy'			=> session()->get("userId"),
					);
					
					$locationStockModel->insert($paramInsertStock);
					// insert location_stock EOF
				}
				
			if ($this->db->transStatus() === false) {
				$this->db->transRollback();
				$returnValue = json_encode(array('status' => "failed", "msg" => "Error data"));
			} else {
				$this->db->transCommit();
				$returnValue = json_encode(array('status' => "success", "msg" => "Data Save Success"));
			}
			
		}
		catch(\Exception $ex)
		{
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}
		
		echo $returnValue;
    }
	
	public function deleteProducts()
    {
		header('Content-Type: application/json');
		
		// get model table
		$productsModel = new \App\Models\ProductsModel();
		
		try
		{
			if(empty( $this->request->getPost() )) {
				throw new \Exception("Data Empty.");
			}
			
			$productId = addslashes($this->request->getPost("productId"));
			
			// delete products
			$delete = $productsModel->delete($productId);
			if($delete) {
				$returnValue = json_encode(array('status' => "success", "msg" => "Delete Success"));
			} else {
				foreach ($customersModel->errors() as $error) {}
				throw new \Exception($error);
			}
			
		}
		catch(\Exception $ex)
		{
			$returnValue = json_encode(array('status' => "failed", "msg" => $ex->getMessage()));
		}
		
		echo $returnValue;
    }
	
	public function formProducts($action = "")
    {
		$data = array(
			'action'		=> $action
		);
		return view("products/addProducts", $data);
	}
	
	public function viewProducts($action = "")
    {
		$data = array(
			'action'		=> $action
		);
		return view("products/viewProducts", $data);
	}
}
