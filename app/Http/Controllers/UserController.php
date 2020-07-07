<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\User\UserInterface as UserInterface;
use DataTables;
use App\Model\UserProduct;

class UserController extends Controller
{
	private $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(){
    	return view('user.index');

    }
    public function userListing(){
    	$users = $this->userRepository->all();
        return Datatables::of($users)
        ->addIndexColumn()
        ->addColumn('action', function($users){
         $btn = '<a href="'.route("user.view","$users->id").'" data-toggle="tooltip"  data-id="'.$users->id.'" data-original-title="View" class="edit btn btn-primary btn-sm viewUser">View</a>';
           // $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$users->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser">Delete</a>';
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

    public function userView($id){
      $users = $this->userRepository->findUser($id);
      $categories = UserProduct::where('user_id',$id)->with('category')->get();
      // dd($categories);
      return view('user.view',compact('users','categories'));
  }

  public function userIsImport(Request $request){
    if ($request->ajax()) {
        $users = UserProduct::where('is_import',1)->with(['users','products','category']);
        return DataTables::eloquent($users)
        // ->addIndexColumn()
        ->addColumn('category', function (UserProduct $category) {
            return $category->category->en_name;
        })
        ->addColumn('products', function (UserProduct $products) {
            return $products->products->en_name;
        })
        ->addColumn('users', function (UserProduct $users) {
            return $users->users->name;
        })
        ->toJson();
    }
        return view('user.isImport');
   }

public function subcat(Request $request){
    $subcategories = UserProduct::where('category_id',$request->cat_id)
    ->with('category.parent')
    ->get();
    return response()->json(['subcategories' => $subcategories]);
}
}
