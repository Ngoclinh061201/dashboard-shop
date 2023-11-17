<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;


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
    // public function getCategoryById(string $id)
    // {
    //     return $this->CategoryRepository->getById($id);
    // }
    // public function getCategoryWithRoles(string $id)
    // {
    //     return $this->CategoryRepository->getCategoryWithRoles($id);
    // }
    
    // public function deleteCategory(string $id)
    // {
    //     $category = $this->CategoryRepository->getCategoryWithRoles($id);
    //     $currentImage = $category->images()->count() > 0 ? $category->images()->first()->url : '';
    //     $category->images()->delete();
    //     $category->deleteImage($currentImage);
    //     $this->CategoryRepository->delete($category);

    // }
    // public function updateCategory(string $id, $request){
        
    //     $dataUpdate = $request->except('password');
    //     $category = $this->CategoryRepository->getCategoryWithRoles($id);
    //     if($request->password){
    //         $dataUpdate['password'] = Hash::make($request['password']);

    //     }

    //     $currentImage = $category->images() ? $category->images()->first()->url : '';
    //     $dataUpdate['image'] = $category->updateImage($request, $currentImage);

    //     $category->images()->delete();
    //     $category->images()->create(["url" => $dataUpdate['image']]);

    //     if (isset($dataUpdate['role_ids'])) {
    //         $category->roles()->sync($dataUpdate['role_ids']);
    //     }
    //     $category = $this->CategoryRepository->update($category, $dataUpdate);
    //     return $category;
    // }

}
