<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface as UserInterface;


class RegisterController extends Controller
{
    /**
     * Initialize Repository
     *@Author Bharti <bharati.tadvi@neosofttech.com>
     *
     * @return \App\Repositories\User\UserRepository
    */
    private $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
 
    /**
     * Store user details while registration.
     *@author Bharti<bharati.tadvi@neosofttech.com>
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function validateMobile(Request $request){
        try {
            $userMobile = $this->userRepository->registerUser($request);
            return $userMobile;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }      
    }

    /**
     * validate mobile and otp while registration.
     *@author Bharti<bharati.tadvi@neosofttech.com>
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return $validateOtp
    */
    public function validateOtp(Request $request){ 
        $validateOtp = $this->userRepository->validateMobileOtp($request);
        return $validateOtp;
    }

    /**
     * After otp verification save the users details.
     *@author Bharti<bharati.tadvi@neosofttech.com>
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return $validateOtp
    */
    public function saveUserDetail(Request $request){
        try {
            $saveUser = $this->userRepository->saveUser($request);
            return $saveUser;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }
        
    }
}
