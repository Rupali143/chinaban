<?php

namespace App\Repositories\Admin;
use App\Model\AdminUser;
use Session;
use App\Repositories\Admin\AdminInterface as AdminInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AdminRepository implements AdminInterface{

	public $adminUser;

    function __construct(AdminUser $adminUser) {
	$this->adminUser = $adminUser;
	}

	/**
    * Authenticate User
    *@Author Bharti <bharati.tadvi@neosofttech.com>
	*
    * @param  $requestData
    * @return $status
	*/
	public function authenticateUser($requestData){
		
		$status = true;
		$username = $requestData->username;
        $password = $requestData->password;
		$checkUser = AdminUser::where('username',$username)->first();
		
		if (!$checkUser) {
			$status = false;
			return $status;
		 }
		if (!Hash::check($password, $checkUser->password)) {
			$status = false;
			return $status;
		}
		Session::put('username',$checkUser->name);
		Session::put('userId',$checkUser->id);
		return $status;
	}

	/**
    * Log out 
    *@Author Bharti <bharati.tadvi@neosofttech.com>
	*
    * @param  $requestData
    * @return $status
	*/
	public function logOutUser($requestData){
		$status = false;
		$userId = Session::get('userId');
        if(isset($userId)){
			$status =true;
            Session::flush();   
        }
	}

	
}