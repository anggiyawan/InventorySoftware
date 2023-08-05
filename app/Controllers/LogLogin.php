<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LogLogin extends BaseController
{
	public function __construct()
	{
		$this->db		= \Config\Database::connect();
		$this->request	= \Config\Services::request();
		$this->session	= \Config\Services::session();
	}
	
    public function index()
    {
        //
    }
	
	public function manage()
    {
        return view('logLogin/logLogin');
    }
	
	public function getJson()
	{
		// get model table
		$logLoginModel = new \App\Models\LogLoginModel();
		
		$page 	= $this->request->getPost('page') != null ? intval($this->request->getPost('page')) : 1;
		$rows 	= $this->request->getPost('rows') != null ? intval($this->request->getPost('rows')) : 50;
		$sort	= $this->request->getPost('sort') != null ? strval($this->request->getPost('sort')) : 'inputDate';
		$order	= $this->request->getPost('order') != null ? strval($this->request->getPost('order')) : 'desc';
		$offset = ($page-1) * $rows;
		
		$query = "SELECT * FROM log_login";

		if ( !empty($this->request->getPost('tglawal')) AND !empty($this->request->getPost('tglakhir')) ) 
		{ 
			$query .= ' WHERE (inputDate BETWEEN "'. date('Y-m-d', strtotime($this->request->getPost('tglawal'))). '" AND "'. date('Y-m-d', strtotime($this->request->getPost('tglakhir') . ' + 1 days')) . '")';
		} else {
			$query .= ' WHERE (inputDate BETWEEN "'. date('Y-m-d'). '" AND "'. date('Y-m-d', strtotime('+ 1 days')) . '")';
		}
		
		if ( !empty($this->request->getPost('userName')) AND $this->request->getPost('userName') != '' ) {
			$query .= " AND userName='" . $this->request->getPost('userName') . "'";
		}
		
		if ( !empty($this->request->getPost('ipAddress')) AND $this->request->getPost('ipAddress') != '' ) {
			$query .= " AND ipAddress='" . $this->request->getPost('ipAddress') . "'";
		}
		
		$query .= " AND userName!='it'";
		
		$result = array();
		$result['total'] = $this->db->query($query)->getNumRows();

		$row = array();
		$query .= " ORDER BY $sort $order limit $offset, $rows";
		
		$criteria 	= $this->db->query( $query );
		
		
		foreach($criteria->getResult() as $data)
		{	
		
			// $model = preg_split("/_/", $data['custom1']);
		
			$row[] = array(
				'id'			=> $data->id,
				'ipAddress'		=> $data->ipAddress,
				'computer'		=> $data->computer,
				'version'		=> $data->version,
				'userId'		=> $data->userId,
				'userName'		=> $data->userName,
				'inputDate'		=> $data->inputDate,
			);
			
		}
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
		//print_r($query);
		
	}
}
