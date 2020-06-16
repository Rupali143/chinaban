<?php

namespace App\Http\Controllers;

use App\Model\Category;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use DataTables;


class CategoryController extends Controller
{
    
    /**
    * Initialize Repository
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @return \App\Repositories\CategoryRepository
    */ 
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->all();
        return view('category.index',compact('categories'));
    }

    public function categoryListing(){
             $categories = $this->categoryRepository->all();
            return Datatables::of($categories)
                    ->addIndexColumn()
                    ->addColumn('action', function($categories){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$categories->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editCategory">Edit</a>';
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$categories->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteCategory">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }


    /**
     * Show the form for creating a new Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Display the specified Category.
     *
     * @param  \App\app\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param  \App\app\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  \App\app\Model\Category  $category
     * @return \Illuminate\Http\Response
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
