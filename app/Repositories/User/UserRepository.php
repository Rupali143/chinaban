<?php

namespace App\Repositories\User;
use App\Model\User;
use App\Model\UserProduct;
use App\Model\Product;
use App\Model\KnowAboutProduct;
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
			'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',

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
			'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
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
			'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
			'name' => 'required',
			'dob' => 'required',
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
	public function registerUser1($data){
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
				'code' => "404",
				'message' => 'validation failed',
				'data'    => $validator->errors(),
            ]);
		}else
        {
			if($data->otp == "1234"){
				$user = User::create(['mobile_number'=> $data->mobile_number]);
				$access_token =  $user->createToken('MyApp')->accessToken;
				return response()->json([
					'code' => 200,
					'message' => "OTP match successfully!!",
					'access_token' => $access_token 
				]);
			}else{
				$arrError['error'] = ['OTP does not match.'];
				return response()->json([
					'code' => "400",
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
	public function saveUser1($data){
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
					'message' => "Registartion done successfully",
					'data'    => $user
				]);
            }else{
				return response()->json([
					'success' => false,
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
            'message' => 'validation failed',
            'data'    => $validator->errors(),
            ]);
		}else
        {
			$user = User::where('mobile_number',$requestData->mobile_number)->first();

			$data['user'] = array('id'=>$user->id,'name'=>$user->name,'dob'=>!empty($user->dob) ? strtotime($user->dob) : '');

			if($requestData->otp == "1234"){
				return response()->json([
					'code' => true,
					'message' => "Login successfully",
					'data'    => $data
				]);
			}else{
				$arrError['error'] = ['OTP does not match.'];
				return response()->json([
					'code' => false,
					'message' => "Otp does not match",
					'data'    => $arrError
				]);
			} 
        }	
	}



	/**
	* Register user Changes
	*@Author Rupali <rupali.satpute@neosofttech.com>
	*
    * @param  $data
    * @return jsonData
	*/

	public function registerUser($data){ 
		$arr['error'] = array();
		$validationRules = $this->validateUserMobile($data->mobile_number);
        $validator = Validator::make($data->all(), $validationRules);
        /*Check for the validations*/
        if ($validator->fails())
        {   
            return response()->json([
				'code' => "412",
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
					'code' => "201",
					'message' => "Mobile number is already exist",
					'data'    => $arrError
				]);		
			}else{
				$phoneNumber = ['Mobile number'=>$data->mobile_number];
				$msg = "Hi,". " Your OTP is 1234";
				return response()->json([
					'code' => "200",
					'message' => $msg,
					'data'    => $phoneNumber
				]); 		
			}	       
        }		 	
	}

	/**
	* Save user Changes
	*@Author Rupali <rupali.satpute@neosofttech.com>
	*
    * @param  $data
    * @return jsonData
	*/
	public function saveUser($data){ 
		$arr['error'] = array();
		$validationRules = $this->validateUser($data);
        $validator = Validator::make($data->all(), $validationRules);
        /*Check for the validations*/
        if ($validator->fails())
        {   
            return response()->json([
				'code' => "412",
				'message' => 'validation failed',
				'data'    => $validator->errors(),
            ]);
		}else
        {
			//data Save to users Table
			// $UpdateDetails = User::where('email', $userEmail)->firstOrFail();
			$user = User::where('mobile_number', $data->mobile_number)->update(['name'=>$data->name,'dob'=>$data->dob,'is_manufacture'=>$data->is_manufacture,'is_profile_complete'=> 1]);
			

			$userId = User::all()->last();
			// dd($userId->id);
			// $access_token =  $user->createToken('MyApp')->accessToken;
			// dd($access_token);

			//data Save to know_about_product Table		
			$storeKnowAboutProduct = KnowAboutProduct::create(
				['en_name' => $data->know_about_product]);
			
			//data Save to products & user_product Table		
			$userProductSave = $data->get('domain_category');

			foreach ($userProductSave as $value) { 
			 	$storeProduct = Product::create(
			 		['en_name' => $value['product_name'],
			 		 'category_id' => $value['category'],
			 		 'product_detail' => $value['product_details']
			 		]);

			 	$storeUserProduct = UserProduct::create([
			 		'category_id' => $value['category'],
			 		'user_id' => $userId->id,
			 		'product_id'=> $storeProduct->id,
			 		'is_import' => $value['is_imported']
			 		]);
			}

			if($user)
            {
				return response()->json([
					'code' => "200",
					'message' => "Registartion done successfully",
					'data'    => $user,
				]);
            }else{
				return response()->json([
					'code' => "412",
					'message' => "Registartion not done successfully",
					'data'    => []
				]);
            }           
		}		 	
	}


	/**
	* Select all users
	*@Author Rupali <rupali.satpute@neosofttech.com>
	*
    * @param 
    * @return users Data
	*/
	public function all(){
		return $users = User::all();
	}

	/**
	* Find user for manage users
	*@Author Rupali <rupali.satpute@neosofttech.com>
	*
    * @param  $id
    * @return users Data
	*/
	public function findUser($id){
		return $users = User::find($id);
	}

	
}