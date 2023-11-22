<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\Product\CreateProductRequest;
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
    public function index()
    {
        // $searchTerm = $request->input('search', '');
        // if ($request->has('search')) {
        //     // $products = $this->productService->searchProducts($searchTerm);
            
        // }else {
            
        // }
        $categories=$this->productService->getCatgories();
        $products = $this->productService->getLatestProducts();
        
        return view('admin.pages.product.index',compact('products','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=$this->productService->getCatgories();
        
        return view ('admin.pages.product.create', compact('categories'));
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
    public function update(Request $request, string $id)
    {
        //
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
