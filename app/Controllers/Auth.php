<?php

namespace App\Controllers;

class Auth extends BaseController
{
	private $session;

	public function __construct()
	{
		$this->request	= \Config\Services::request();
		// $this->session	= \Config\Services::session();
		$this->session = session();
	}

	// {{url}}/Login
	public function login()
	{
		$this->session->setFlashdata('message', '');
		$userModel = new \App\Models\UsersModel();

		// set data
		$data = array(
			'ipAddress'		=> $this->request->getIPAddress(),
			'getBrowser'	=> $this->getBrowser()
		);

		// set post
		$user = $this->request->getPostGet('txtuser');
		$pass = $this->request->getPostGet('txtpassword');

		try {

			if ($user and $pass) {
				$passHash = hash("sha256", $pass);
				// Cek apakah user telah menginput username dan password
				$checkUser = $userModel->where(array("userName" => $user))->first();

				if ($checkUser == null) {
					throw new \Exception("Incorrect Username.");
				} elseif ($checkUser->statusId == 1) {

					if ($checkUser->password !== $passHash) {
						throw new \Exception("Incorrect Password.");
					}
					$sessionLogin = [
						'userId' 		=> $checkUser->userId,
						'userName' 		=> $checkUser->userName,
						'fullName'		=> $checkUser->fullName,
						'deptId' 		=> $checkUser->deptId,
						'groupId' 		=> $checkUser->groupId,
						'version' 		=> VERSION,
						'is_login' 		=> true
					];

					$this->session->set($sessionLogin);

					//update last login
					$paramLogin = array(
						'lastLogin'	=> date('Y-m-d H:i:s'),
					);
					$userModel->update(array("userId" => $checkUser->userId), $paramLogin);

					//insert log ip address
					$userModel->setLoginHistory();
					if (isset($userModel->lastUrl)) {
						redirect($userModel->lastUrl);
					} else {
						return redirect()->route('home');
					}
				} elseif ($checkUser->statusId == 2) {
					throw new \Exception("Account Disabled.");
				} else {
					throw new \Exception("Incorrect Login.");
				}

				return view('login', $data);
			} else {
				if (!$this->session->get('is_login')) {
					return view('login', $data);
				} else {
					return redirect()->route('home');
				}
			}
		} catch (\Exception $ex) {
			$this->session->setFlashdata('message', $ex->getMessage());
			return view('login', $data);
		}
	}

	// {{url}}/Logout
	public function logout()
	{
		//update last login
		$paramLogin = array(
			'lastUrl'	=> @$_SERVER['HTTP_REFERER']
		);

		$userModel = new \App\Models\UsersModel();
		$userModel->update(array('userId' => $this->session->get('userId')), $paramLogin);

		$sessionLogin = array(
			'userId',
			'userName',
			'fullName',
			'deptId',
			'groupId',
			'hostname',
			'is_login'
		);

		$this->session->remove($sessionLogin);
		// echo "test";
		echo "<script> document.location.href = '" . base_url('login') . "';</script>";
		// echo "<script> document.location = 'www.facebook.com';</script>";
		// return redirect("www.facebook.com"); //->route('test');

	}
	private function getBrowser()
	{

		$user_agent = $_SERVER['HTTP_USER_AGENT'];

		if (preg_match('/MSIE/i', $user_agent)) {
			$browser = "Internet Explorer";
		} elseif (preg_match('/Firefox/i', $user_agent)) {
			$browser = "Mozilla Firefox";
		} elseif (preg_match('/Chrome/i', $user_agent)) {
			$browser = "Google Chrome";
		} elseif (preg_match('/Safari/i', $user_agent)) {
			$browser = "Safari";
		} elseif (preg_match('/Opera/i', $user_agent)) {
			$browser = "Opera";
		} else {
			$browser = "Other";
		}

		return $browser;
	}
}
