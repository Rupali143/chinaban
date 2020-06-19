<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Repositories\Admin\AdminInterface as AdminInterface;


class LoginController extends Controller
{   
     /**
    * Initialize Repository
    *@Author Bharti <bharati.tadvi@neosofttech.com>
    *
    * @return \App\Repositories\AdminRepository
    */ 
    private $adminRepository;

    public function __construct(AdminInterface $adminRepository){
        $this->adminRepository = $adminRepository;
    }

    /**
    * Show the application dashboard.
    *@author Bharti<bharati.tadvi@neosofttech.com> 
    * 
    *@return void
    */
    public function dashboard(){
        return view('layouts.master');
    }
 
    /**
    * Show the login form.
    *@author Bharti<bharati.tadvi@neosofttech.com>
    *
    * @return  void
    */
    public function create(){
        return view('login');
    }

    /**
    * Validate admin user.
    *@author Bharti<bharati.tadvi@neosofttech.com>
    * 
    * @param $userRequest
    * @return void
    */
    protected function validateUser($userRequest){

        $validatedData = $userRequest->validate([
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ]);
    }
    
    /**
    * Authenticate login user.
    *@author Bharti<bharati.tadvi@neosofttech.com>
    * 
    * @param  \Illuminate\Http\Request  $request
    * @return void
    */
    public function authenticate(Request $request){
        
        $validationRules = $this->validateuser($request);
        try{
            $authenticateUser = $this->adminRepository->authenticateUser($request);
            if($authenticateUser){
                return redirect()->route('admin.dashboard.index')->with('success','Log in successfully');
            }
            return redirect()->route('admin.login')->with('error','Invalid username or password');
        }catch(\Exception $ex){
            return redirect()->route('admin.login')->with('error',$ex->getMessage);
        } 
    }

    /**
    * Logout user.
    *@author Bharti<bharati.tadvi@neosofttech.com>
    * 
    * @param  \Illuminate\Http\Request  $request
    * @return void
    */
    public function logout(Request $request) {
        
       $logOutUser = $this->adminRepository->logOutUser($request);
       return redirect()->route('admin.login');      
    }    
}
