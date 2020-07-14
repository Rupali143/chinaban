<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\User\UserInterface as UserInterface;
use DataTables;
use App\Model\UserProduct;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
    * User Repository Initialized
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param  
    * @return 
    */
    private $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
    * Index for Users
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param  
    * @return view
    */
    public function index(){
    	return view('admin.user.index');

    }

    /**
    * Listing for Users
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param 
    * @return $users with dataTable 
    */
    public function userListing(){
    	$users = $this->userRepository->all();
        return Datatables::of($users)
        ->addIndexColumn()
        ->addColumn('action', function($users){
           $btn = '<a href="'.route("user.view","$users->id").'" data-toggle="tooltip"  data-id="'.$users->id.'" data-original-title="View" class="edit btn btn-primary btn-sm viewUser">View</a>';
           return $btn;
       })
        ->editColumn('is_manufacture', function($users) {
            if($users->is_manufacture == 1){
                return "Yes";
            }else{
                return "No";
            }

        })
        ->rawColumns(['action','is_manufacture'])
        ->make(true);
    }


    /**
    * View page for Users
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param $id
    * @return view with users & related categories
    */
    public function userView($id){
      $users = $this->userRepository->findUser($id);
      $categories = UserProduct::where('user_id',$id)->with('category')->get();
      return view('admin.user.view',compact('users','categories'));
  }

    /**
    * If import produts outside 
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param $request
    * @return $users with dataTable 
    */
    public function userIsImport(Request $request){
        if ($request->ajax()) {
            $users = UserProduct::where('is_import',1)->with(['users','products','category']);
            return DataTables::eloquent($users)
            ->addColumn('category', function (UserProduct $category) {
                return $category->category['en_name'];
            })
            ->addColumn('products', function (UserProduct $products) {
                return $products->products['en_name'];
            })
            ->addColumn('users', function (UserProduct $users) {
                return $users->users->name;
            })
            ->toJson();
        }
        return view('admin.user.isImport');
    }

   /**
    * Based on category_id fetched subCategory 
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param $request
    * @return $json 
    */
   public function subcat(Request $request){
    $subcategories = UserProduct::where('category_id',$request->cat_id)
    ->with('category.parent')
    ->get();
    return response()->json(['subcategories' => $subcategories]);
   }
}
