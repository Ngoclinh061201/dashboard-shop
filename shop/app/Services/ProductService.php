<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;


class ProductService
{
    protected $productRepository;
    protected $categoryRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function getLatestProducts()
    {
        $products = $this->productRepository->latestProducts();
        return $this->productRepository->paginateProducts($products, 5);
    }

    public function searchProducts($key, $category)
    {
        return $this->productRepository->searchProducts($key, $category);
    }

    public function createProduct( $request)
    {
        $dataCreate = $request->validated();
        $dataCreate['image'] = $this->productRepository->saveImage($request);
        $product = $this->productRepository->create($dataCreate);
        $product->images()->create(["url" => $dataCreate['image']]);
        if (isset($dataCreate['category_ids'])) {
            $product->categories()->attach($dataCreate['category_ids']);
        }
        return $product;
    }

    public function getProductById(string $id)
    {
        return $this->productRepository->getByIdWithRelationships($id);
    }

    public function getProductWithCategories(string $id)
    {
        return $this->productRepository->getProductWithCategories($id);
    }
    
    public function deleteProduct(string $id)
    {
        $product = $this->productRepository->getProductWithCategories($id);
        $currentImage = $product->images()->count() > 0 ? $product->images()->first()->url : '';
        $product->images()->delete();
        $product->deleteImage($currentImage);
        $this->productRepository->delete($product);
    }

    public function updateProduct(string $id, $request)
    {
        $dataUpdate = $request->all();
        $product = $this->productRepository->getProductWithCategories($id);
        $currentImage = $product->images()->count()>0 ? $product->images()->first()->url : '';
        $dataUpdate['image'] = $product->updateImage($request, $currentImage);
        $product->images()->delete();
        $product->images()->create(["url" => $dataUpdate['image']]);
        if (isset($dataUpdate['role_ids'])) {
            $product->roles()->sync($dataUpdate['role_ids']);
        }
        $product = $this->productRepository->update($product, $dataUpdate);
        return $product;
    }

    public function getCatgories()
    {
        return $categories=$this->categoryRepository->getCatgories();
    } 
}
