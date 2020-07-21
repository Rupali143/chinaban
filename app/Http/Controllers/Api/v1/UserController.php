<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface as UserInterface;


class UserController extends Controller
{
    /**
     * Initialize Repository
     *@Author Rupali <rupali.satpute@neosofttech.com>
     * @return \App\Repositories\User\UserRepository
    */
    private $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**Fetch user category
    *@Author Rupali <rupali.satpute@neosofttech.com>
    * @param  $request
    * @return $userCategory in JSON format
    */
    public function getUserCategory(Request $request){
    	try {
            $userCategory = $this->userRepository->getUserCategory($request->user_id);
            return $userCategory;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }
    }


    /**Fetch user produt
    *@Author Rupali <rupali.satpute@neosofttech.com>
    * @param  $request
    * @return $userProdut in JSON format
    */
    public function getUserProduct(Request $request){
    	try {
            $userProdut = $this->userRepository->getUserProduct($request->user_id);
            return $userProdut;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }  
    }


    /**Fetch user profile
    *@Author Rupali <rupali.satpute@neosofttech.com>
    * @param  $request
    * @return $userProfile in JSON format
    */
    public function getUserProfile(Request $request){
        // dd($request->user_id);
        try {
            $userProfile = $this->userRepository->getuserProfile($request->user_id);
            return $userProfile;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }
    }
}