<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $searchTerm = $request->input('search', '');
        if ($request->has('search')) {
            $categories = $this->categoryService->searchCategories($searchTerm);
        } else {
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
        $category = $this->categoryService->getCategoryWithChildrens($id);
        return view('admin.pages.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $parentCategories = $this->categoryService->getParents();
        $category = $this->categoryService->getCategoryWithChildrens($id);
        return view ('admin.pages.category.edit', compact('parentCategories', 'category'));
    }

    /**
     * Update the specified resource in storage
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = $this->categoryService->updateCategory($id, $request );
        return redirect()->route('categories.index')->with('success', 'edit successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->categoryService->deleteCategory($id);
        return redirect()->route('categories.index')->with('success', 'edit successfully');

    }
}
