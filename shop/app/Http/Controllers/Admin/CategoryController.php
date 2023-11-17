<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Requests\Category\CreateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $categoryService;
    public function __construct(CategoryService $categoryService){
        $this->categoryService = $categoryService;
    }
    
    public function index(Request $request)
    {
        $searchTerm = $request->input('search', '');
        if ($request->has('search')) {
            $categories = $this->categoryService->searchCategories($searchTerm);
            
        }else {
            $categories = $this->categoryService->getLatestCategories();
        }
        
        return view('admin.pages.category.index',compact('categories', 'searchTerm'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()

    {
        $parentCategories = $this->categoryService->getParents();
        return view ('admin.pages.category.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = $this->categoryService->createCategory($request);
        return redirect()->route('categories.index')->with('success', 'Create successfully');
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
        //
    }
}
