<?php 

namespace App\Repositories\Admin;
use App\Model\AdminUser;
use Illuminate\Http\Request;

interface AdminInterface{ 
	public function authenticateUser($requestData);
	public function logOutUser($requestData);
}