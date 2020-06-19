<?php 

namespace App\Repositories\Admin;
use App\AdminUser;
use Illuminate\Http\Request;

interface AdminInterface{ 
	public function authenticateUser($requestData);
	public function logOutUser($requestData);
}