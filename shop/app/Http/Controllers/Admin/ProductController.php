<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;

class ProductController extends Controller
{

    protected $productService;
    public function __construct(ProductService $productService){
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
            // get search products
        $keySearch = $request->input('searchInput', '');
        $categorySearch=$request->input('searchCategory', '');
      
        if (!empty($keySearch) || !empty($categorySearch)) { 
            $products = $this->productService->searchProducts($keySearch, $categorySearch);
            $roles = auth()->user()->roles;
            if ($products) {
                return response()->json(['product' => $products, 'roles' => $roles]);
            }
        } else {
           //  get all products
            $products = $this->productService->getLatestProducts();
        }
        $categories=$this->productService->getCatgories();
        return view('admin.pages.product.index',compact('products','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        try {
            $validatedData = $request->validate($request->rules());
            $product = $this->productService->createProduct($request);
            
            return response()->json(['message' => 'Data saved successfully'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            
            return response()->json(['errors' => $e->errors(), 'message' => 'Validation failed'], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product=$this->productService->getProductById($id);
        
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json(['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product=$this->productService->getProductById($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json(['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        
        try {
            $validatedData = $request->validate($request->rules());
            $product = $this->productService->updateProduct($id, $request);
            
            return response()->json(['message' => 'Update successfully'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            
            return response()->json(['errors' => $e->errors(), 'message' => 'Validation failed'], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->productService->deleteProduct($id);
        return redirect()->route('products.index')->with('success', 'Delete successfully');
    }
}
