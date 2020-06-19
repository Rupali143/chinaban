<?php

namespace App\Repositories\User;
use App\Model\User;
use App\Repositories\User\UserInterface as UserInterface;
use Illuminate\Support\Facades\Validator;

class UserRepository implements UserInterface{

	public $user;

    function __construct(User $user) {
	$this->user = $user;
	}
	
	/**
	* Validate user mobile number.
	*@author Bharti<bharati.tadvi@neosofttech.com>
	* 
	* @param $userRequest
	* @return $rules
    */
    protected function validateUserMobile($userRequest){

        $rules = [
			'mobile_number' => 'required',
		];
		return $rules;
    }
	
    /**
	* Validate Otp.
	*@author Bharti<bharati.tadvi@neosofttech.com>
	* 
	* @param $userRequest
	* @return $rules
    */
    protected function validateMobileOtpRule($userRequest){

        $rules = [
			'mobile_number' => 'required',
			'otp' => 'required',
		];
		return $rules;
	}

	/**
	* Validate user while registration.
	*@author Bharti<bharati.tadvi@neosofttech.com>
	* 
	* @param $userRequest
	* @return $rules
    */
    protected function validateUser($userRequest){

        $rules = [
			'mobile_number' => 'required',
			'name' => 'required',
			'dob' => 'required',
            'know_about_product' => 'required',
            'is_manufacture' => 'required',
		];
		return $rules;
	}
	
	/**
    * Validate mobile number to sent otp
    *@Author Bharti <bharati.tadvi@neosofttech.com>
	*
    * @param  $data
    * @return \Illuminate\Http\Response
	*/
	public function registerUser($data){
		$arr['error'] = array();
		$validationRules = $this->validateUserMobile($data);
        $validator = Validator::make($data->all(), $validationRules);
        /*Check for the validations*/
        if ($validator->fails())
        {   
            return response()->json([
				'success' => false,
				'is_expired'=>false,
				'message' => 'validation failed',
				'data'    => $validator->errors(),
            ]);
		}else
        {  
			$msg = '';
			$userObj = User::where('mobile_number',$data->mobile_number)->first();
		
			if($userObj){
				$arrError['error'] = ['Mobile number is already exist.'];
				return response()->json([
					'success' => false,
					'message' => "Mobile number is already exist",
					'data'    => $arrError
				]);		
			}else{
				$phoneNumber = ['Mobile number'=>$data->mobile_number];
				$msg = "Hi,". " Your OTP is 1234";
				return response()->json([
					'success' => true,
					'message' => $msg,
					'data'    => $phoneNumber
				]); 		
			}	       
        }		 	
	}


	/**
    *@Author Bharti <bharati.tadvi@neosofttech.com>
	*
    * @param  $data
    * @return \Illuminate\Http\Response
	*/

	public function validateMobileOtp($data){
		$arr['error'] = array();
		$validationRules = $this->validateMobileOtpRule($data);
        $validator = Validator::make($data->all(), $validationRules);
        /*Check for the validations*/
        if ($validator->fails())
        {   
            return response()->json([
				'success' => false,
				'is_expired'=>false,
				'message' => 'validation failed',
				'data'    => $validator->errors(),
            ]);
		}else
        {
			if($data->otp == "1234"){
				return response()->json([
					'success' => true,
					'message' => "OTP verified successfully",
					'data'    => []
				]);
			}else{
				$arrError['error'] = ['OTP does not match.'];
				return response()->json([
					'success' => false,
					'message' => "Otp does not match",
					'data'    => $arrError
				]);
			} 
        }		 	
	}

    /**
	* Save user details
	*@Author Bharti <bharati.tadvi@neosofttech.com>
	*
    * @param  $data
    * @return \Illuminate\Http\Response
	*/
	public function saveUser($data){
		$arr['error'] = array();
		$validationRules = $this->validateUser($data);
		
        $validator = Validator::make($data->all(), $validationRules);
        /*Check for the validations*/
        if ($validator->fails())
        {   
            return response()->json([
				'success' => false,
				'is_expired'=>false,
				'message' => 'validation failed',
				'data'    => $validator->errors(),
            ]);
		}else
        {
			
			$user = User::create(['mobile_number'=>$data->mobile_number,'name'=>$data->name,'dob'=>$data->dob,'know_about_product'=>$data->know_about_product,'is_manufacture'=>$data->is_manufacture]);			
			
			if($user)
            {
				return response()->json([
					'success' => true,
					'is_expired'=>false,
					'message' => "Registartion done successfully",
					'data'    => $user
				]);
            }else{
				return response()->json([
					'success' => false,
					'is_expired'=>false,
					'message' => "Registartion not done successfully",
					'data'    => []
				]);
            }           
		}		 	
	}

	/**
	* Login user 
	*@Author Bharti <bharati.tadvi@neosofttech.com>
	*
    * @param  $requestData
    * @return \Illuminate\Http\Response
	*/
	public function userSignIn($requestData){
		$arr['error'] = array();
		$validationRules = $this->validateUserMobile($requestData);
		$validator = Validator::make($requestData->all(), $validationRules);
        /*Check for the validations*/
        if ($validator->fails())
        {   
            return response()->json([
				'success' => false,
				'is_expired'=>false,
				'message' => 'validation failed',
				'data'    => $validator->errors(),
            ]);
		}else
        {
			$user = User::where('mobile_number',$requestData->mobile_number)->first();

			$data['user'] = array('id'=>$user->id,'name'=>$user->name,'dob'=>!empty($user->dob) ? strtotime($user->dob) : '');

			if(!empty($user)){
				$msg = '';
				$msg = "Hi,". " Your OTP is 1234";
				return response()->json([
					'success' => true,
					'message' => $msg,
					'data'    => []
			    ]);
			}else{
				$arrError['error'] = ['Mobile number not exist'];
                return response()->json([
                    'success' => false,
                    'message' => "Mobile number not exist",
                    'data'    => $arrError
                ]);
			}     
        }
	}

	/**
	* Verify Otp to login 
	*@Author Bharti <bharati.tadvi@neosofttech.com>
	*
    * @param  $requestData
    * @return \Illuminate\Http\Response
	*/
	public function verifyOtp($requestData){
		$arr['error'] = array();
		$validationRules = $this->validateMobileOtpRule($requestData);

		$validator = Validator::make($requestData->all(), $validationRules);
        /*Check for the validations*/
        if ($validator->fails())
        {   
            return response()->json([
            'success' => false,
            'is_expired'=>false,
            'message' => 'validation failed',
            'data'    => $validator->errors(),
            ]);
		}else
        {
			$user = User::where('mobile_number',$requestData->mobile_number)->first();

			$data['user'] = array('id'=>$user->id,'name'=>$user->name,'dob'=>!empty($user->dob) ? strtotime($user->dob) : '');

			if($requestData->otp == "1234"){
				return response()->json([
					'success' => true,
					'message' => "Login successfully",
					'data'    => $data
				]);
			}else{
				$arrError['error'] = ['OTP does not match.'];
				return response()->json([
					'success' => false,
					'message' => "Otp does not match",
					'data'    => $arrError
				]);
			} 
        }	
	}
}