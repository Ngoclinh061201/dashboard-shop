<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;

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
        $products = $this->productService->getLatestProducts();
        return view('admin.pages.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $categories=$this->productService->getCatgories();
        // return view ('admin.pages.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd(10);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        return redirect()->route('products.index')->with('success', 'edit successfully');
    }
}
