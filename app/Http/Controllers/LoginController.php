<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminUser;
use Session;


class LoginController extends Controller
{   
    /**
    * Show the application dashboard.
    *@author Bharti<bharati.tadvi@neosofttech.com> 
    * 
    * @return void
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
            $username = $request->username;
            $password = $request->password;
            
            $checkUser = AdminUser::where(['username'=>$username,'password'=>$password])->first();
            
            if ($checkUser){
                Session::put('username',$request->username);
                Session::put('userId',$checkUser->id); 
                return redirect()->route('admin.dashboard.index')->with('success','Log in successfully');
            }else{
                return redirect()->route('admin.login')->with('error','Invalid username or password');
            } 
        }catch(\Exception $ex){
            return redirect()->route('admin.login')->with('error',$ex->getMessage);
        }           
    }

    /**
    * logout user.
    *@author Bharti<bharati.tadvi@neosofttech.com>
    * 
    * @param  \Illuminate\Http\Request  $request
    * @return void
    */
    public function logout(Request $request) {
        
        $userName = Session::get('username');
        $userId = Session::get('userId');
        if(isset($userName) || isset($userId)){
            Session::flush();
            return redirect('/login');    
        }    
    }    
}
