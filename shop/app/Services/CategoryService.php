<?php
namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Hash;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getLatestCategories()
    {
        $categories = $this->categoryRepository->latestcategories();
        return $this->categoryRepository->paginatecategories($categories, 5);
    }

    public function searchCategories($searchTerm){
        $categories = $this->categoryRepository->searchCategories($searchTerm);
        return $this->categoryRepository->paginateCategories($categories, 5);
    }

    public function getParents(){
        return $this->categoryRepository->getParents();
    }

    public function createCategory( $request)
    {
        $dataCreate = $request->all();
        $this->categoryRepository->create($dataCreate);
    }

    public function getCategoryWithParents(string $id)
    {
        return $this->categoryRepository->getCategoryWithParents($id);
    }
    
    public function getCategoryWithChildrens(string $id)
    {
        return $this->categoryRepository->getCategoryWithChildrens($id);
    }
    
    public function deleteCategory(string $id)
    {
        $category = $this->categoryRepository->getById($id);
        $this->categoryRepository->delete($category);
    }

    public function updateCategory(string $id, $request)
    {
        $dataUpdate = $request->all();
        $category = $this->categoryRepository->getById($id);
        $this->categoryRepository->update($category, $dataUpdate);
    }
}
