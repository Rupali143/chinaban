<?php 

namespace App\Repositories\User;

interface UserInterface{

    public function registerUser($data);
    public function validateMobileOtp($data);
    public function userSignIn($requestData);
    public function verifyOtp($requestData);  

}