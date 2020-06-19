<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Model\Product;
use App\Model\Category;
use App\Repositories\Product\ProductInterface as ProductInterface;


class ProductController extends Controller
{
    /**
    * Initialize Repository
    *@Author Bharti <bharati.tadvi@neosofttech.com>
    *
    * @return \App\Repositories\ProductRepository
    */ 

    private $productRepository;

    public function __construct(ProductInterface $productRepository){
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the Product.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepository->all();
        $categories = Category::get();
        return view('product.index',compact('products','categories'));
    }

    public function productListing(){
        $products = $this->productRepository->all();
        
        return Datatables::of($products)
        ->addIndexColumn()
        ->addColumn('category_name', function($products){
            return $products->category->en_name;
        })
        ->addColumn('action', function($products){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$products->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$products->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
                return $btn;
            })
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * Store a newly created Product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        try {
            $product = $this->productRepository->save($request);
            return response()->json(['success'=>'Product saved successfully.']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }
    }

    /**
     * Show the form for editing the specified Product.
     *
     * @param  \App\app\Model\Product  $product
     * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\app\Model\Product  $product
     * @return \Illuminate\Http\Response
    */
    public function destroy($id){
        try {
            $destroyProduct = $this->productRepository->delete($id);
            return response()->json(['success'=>'Product deleted successfully.']);
        }catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }
    }

}
