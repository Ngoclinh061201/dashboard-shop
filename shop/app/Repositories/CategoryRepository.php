<?php
namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Hash;


class CategoryRepository
{
    protected $categories;

    public function __construct(Category $categories)
    {
        $this->categories = $categories;
    }

    public function searchCategories($searchTerm)
    {
        return $categories= $this->categories->search($searchTerm);
    }
    public function getParents(){
        return $this->categories->getParents();
    }

    public function latestCategories()
    {
        return $this->categories->latest('updated_at');
    }

    public function paginateCategories($categories, $perPage)
    {
        return $categories->paginate($perPage);
    }

    public function create($dataCreate)
    {
        return $categories =  $this->categories->create($dataCreate);
        
    }

    public function getById(string $id)
    {
        return $this->categories->findOrFail($id);
    }

    public function getCategoryWithParents(string $id)
    {
        return $this->categories->with('parent')->findOrFail($id);
    }
    public function getCategoryWithChildrens(string $id)
    {
        return $this->categories->with('childrens')->findOrFail($id);
    }

    public function update(Category $category, array $data)
    {
       
        $category = $category->update($data);
        return $category;
    }
    
    public function delete(Category $category)
    {
        $category->delete();
    }
    public function saveImage($request){
        return $this->categories->saveImage($request);
    }
    
}
