<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'userId';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = ['userId', 'userName', 'fullName', 'email', 'groupId', 'statusId', 'changePassword', 'deptId', 'password', 'lastUrl', 'lastLogin', 'inputBy', 'updateBy', 'deleteBy'];

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
    protected $beforeInsert   = ["hashPassword"];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ["hashPassword"];
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
		$sql = "SELECT users.*, groups.groupId, groups.groupName FROM users INNER JOIN groups ON users.groupId=groups.groupId";
		$sql .= " AND users.statusId!=0";
		if ( isset($_POST['userName'])) 
		{
			$sql .= " AND users.userName LIKE '%" . $_POST['userName'] . "%'";
		}
		
		if ( isset($_POST['groupId'])) 
		{
			$sql .= " AND groups.groupId LIKE '%" . $_POST['groupId'] . "%'";
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
	
	// public function autoUsersId($configName)
	// {
		// $builder = $this->db->query("SELECT prefix, max(RIGHT(number, 6)) as numberId FROM `auto_number` WHERE `configName`='" . $configName . "'");
		
		// $numberIncrement = 1 + $builder->getRow()->numberId;
		// $NumberSprint = "" . sprintf("%06s", $numberIncrement) ;
		// return $builder->getRow()->prefix . $NumberSprint;
	// }
	
	public function changePassword()
    {
		$db			= \Config\Database::connect();
		$request	= \Config\Services::request();
		
		if ( empty($request->getPost("password")) ) {
			return false;
		}
		
		if ( empty($request->getPost("userId")) ) {
			return false;
		}
		
		$paramUpdate = [
			'password' => $request->getPost("password")
		];
		$db->update(array('userId' => $request->getPost("userId")), $paramUpdate);

        $sql = "UPDATE `db`.`users` SET `password`='" . $request->getPost("password") . "' WHERE `userId`='" . $request->getPost("userId") . "'";

        $this->db->query($sql);
		
		return true;
    }
	
	public function setLoginHistory()
	{
		$db			= \Config\Database::connect();
		$session	= \Config\Services::session();
		$request	= \Config\Services::request();
		
		if ( !empty($session->get('hostname')) ) {
			$hostname = $session->get('hostname');
		} else {
			$hostname = gethostname();
		}
		
		$ipAddress 	= $request->getIPAddress();
		$computer	= substr($hostname, 0, 255); //gethostname(),
		$userId		= $session->get('userId');
		$userName	= $session->get('userName');
		$version	= $session->get('version');
		$inputDate 	= date('Y-m-d H:i:s'); //date('Y-m-d', strtotime(date('Y-m-d H:i:s')));
		
		return $this->db->query("INSERT INTO `log_login` (`ipAddress`, `computer`, `userId`, `userName`, `version`, `inputDate`)
			VALUES ('".$ipAddress."', '".$computer."', '".$userId."', '".$userName."', '".$version."', '".$inputDate."')");
	}
	
	protected function hashPassword(array $data)
    {
        if (! isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = hash("sha256", $data['data']['password']);
        // unset($data['data']['password']);

        return $data;
    }

	protected function callAfterDelete(array $data)
    {
		if (! isset($data['id']['0'])) {
            return $data;
        }
		
		$userId = addslashes($data['id']['0']); // userId
		
        $sql = "UPDATE `users` SET `statusId`=0, `deleteBy`='".session()->get('userId')."' WHERE `userId`='".$userId."';";

        $builder = $this->db->query($sql);
		
		return $data;
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
