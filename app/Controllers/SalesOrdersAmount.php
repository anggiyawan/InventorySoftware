<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SalesOrdersAmount extends BaseController
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
	
	public function getJson()
    {
		// helper
		Helper('web');
		
		// get model table
		$salesOrdersAmountModel = new \App\Models\SalesOrdersAmountModel();

        $page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'salesOrderId';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'desc';
		$offset = ($page-1) * $rows;
		
		$result = array();
		$result['total'] = $salesOrdersAmountModel->getCount();
		$row = array();
		
		$criteria = $salesOrdersAmountModel->getAll(array("sort" => $sort, "order" => $order, "offset" => $offset, "rows" => $rows));
		
		foreach($criteria as $data)
		{
			$row[] = array(
				'salesOrderId'		=> $data->salesOrderId,
				'name'				=> $data->name,
				'title'				=> $data->title,
				'value'				=> \FormatCurrency((int)$data->value),
				'inputBy'			=> $data->inputBy,
				'inputDate'			=> date('Y-m-d', strtotime($data->inputDate)),
				'updateBy'			=> $data->updateBy,
				'updateDate'		=> date('Y-m-d', strtotime($data->updateDate))
			);
			
		}
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
    }
	
	public function getJsonDetails()
    {
		// helper
		Helper('web');
		
		// get model table
		$salesOrdersAmountModel = new \App\Models\SalesOrdersAmountModel();

        $page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'sort';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'asc';
		$offset = ($page-1) * $rows;
		
		$result = array();
		$result['total'] = $salesOrdersAmountModel->getCount();
		$row = array();
		$subTotal = 0;
		
		$criteria = $salesOrdersAmountModel->getAll(array("sort" => $sort, "order" => $order, "offset" => $offset, "rows" => $rows));
		
		foreach($criteria as $data)
		{	
			if ( $data->statusId == \USERS::ACTIVE ) {
		        $status = "<img src='" . base_url('assets/css/icons/st_green.gif') . "'> Active";
			}
		    else if ( $data->statusId == \USERS::DISABLED ) {
		        $status = "<img src='" . base_url('assets/css/icons/st_red.gif') . "'> Disable";
			}
			
			$row[] = array(
				'salesOrderDetailId'	=> $data->salesOrderDetailId,
				'salesOrderNumber'		=> $data->salesOrderNumber,
				'productId'				=> $data->productId,
				'productNumber'			=> $data->productNumber,
				'productName'			=> $data->productName,
				'priceSell'				=> $data->priceSell,
				'quantity'				=> $data->quantity,
				'delivery'				=> $salesOrdersDetailsModel->getDelivered($data->salesOrderDetailId, $data->productId),
				'totalAmount'			=> $data->amount,
				'amount'				=> \FormatCurrency($data->amount),
				'unit'					=> $data->unit,
			);
			
			$subTotal += $data->amount;
		}
		
		$result=array_merge($result,array('rows'=>$row, 'subTotal' => $subTotal));
		return json_encode($result);
    }
	
}
