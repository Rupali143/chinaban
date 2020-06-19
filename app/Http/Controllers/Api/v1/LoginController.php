<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface as UserInterface;

class LoginController extends Controller
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
     * Sign in user.
     *@author Bharti<bharati.tadvi@neosofttech.com>
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response,$userSignIn
    */
    public function signIn(Request $request){
        try {
            $userSignIn = $this->userRepository->userSignIn($request);
            return $userSignIn;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }      
    }


    /**
     * Verify otp.
     *@author Bharti<bharati.tadvi@neosofttech.com>
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response,$verifyOtp
    */
    public function verifyUserOtp(Request $request){
        try {
            $verifyOtp = $this->userRepository->verifyOtp($request);
            return $verifyOtp;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }      
    }

}
