<?php

namespace App\Http\Controllers;

use App\Model\Category;
use Illuminate\Http\Request;
use App\Repositories\Category\CategoryInterface as CategoryInterface;
use DataTables;


class CategoryController extends Controller
{

    /**
    * Repository Initialized
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param  
    * @return 
    */
    private $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }

    /**
    * Index for Category & Images
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param  $null
    * @return $categories
    */
    public function index()
    {
        $categories = $this->categoryRepository->all();
        return view('category.index',compact('categories'));
    }

    /**
    * Listing for  Category & Images
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param  null
    * @return $category with dataTable 
    */

    public function categoryListing(){
        $categories = $this->categoryRepository->all();
        // dd($categories->toArray());
        $configPath = config('app.file_path');
        return Datatables::of($categories)
        ->addIndexColumn()
        ->addColumn('action', function($categories){
         $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$categories->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editCategory">Edit</a>';
         $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$categories->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteCategory">Delete</a>';
         return $btn;
     })
        ->addColumn('image', function($categories){
         $image = '<img src="storage/images/'.$categories->image->image_location.'" style="height:50px;width:50px;">';
         return $image;
     })
        ->editColumn('parent_category', function($categories) {
            if(is_null($categories->parent)){
                return "Parent";
            }else{
                return $categories->parent->en_name;
            }
                    
        })
        ->rawColumns(['action','image','parent_category'])
        ->make(true);
    }



    /**
    * Store  Category & Images
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param  $id
    * @return $category with json
    */
    public function store(Request $request)
    {
       
        try {
            $categories = $this->categoryRepository->save($request);
            return response()->json(['success'=>'Category saved successfully.']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }
    }

    /**
    * Edit for  Category & Images
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param  $id
    * @return $category with json
    */
    public function edit($id)
    {
        $category = Category::with('getImage','parent')->find($id);
        // dd($category->parent);
        return response()->json($category);
    }

    /**
    *Destroy  Category & Images
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param  $id
    * @return $success message
    */
    public function destroy($id)
    {
        try {
            $destroyCategory = $this->categoryRepository->delete($id);
            return response()->json(['success'=>'Category deleted successfully.']);
        }catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }
    }
}
