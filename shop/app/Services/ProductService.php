<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;


class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getLatestProducts()
    {
        $products = $this->productRepository->latestProducts();

        return $this->productRepository->paginateProducts($products, 5);
    }

    public function searchProducts($searchTerm)
    {
        return $this->productRepository->searchProducts($searchTerm);
    }

    public function createProduct( $request)
    {
       
        $dataCreate = $request->all();
        $dataCreate['password'] = Hash::make($request->password);
        $dataCreate['image'] = $this->productRepository->saveImage($request);
        $product = $this->productRepository->create($dataCreate);
        $product->images()->create(["url" => $dataCreate['image']]);

        if (isset($dataCreate['role_ids'])) {
            $product->roles()->attach($dataCreate['role_ids']);
        }
        

    }
    public function getProductById(string $id)
    {
        return $this->productRepository->getById($id);
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
    public function updateProduct(string $id, $request){
        
        $dataUpdate = $request->except('password');
        $product = $this->productRepository->getProductWithCategories($id);
        if($request->password){
            $dataUpdate['password'] = Hash::make($request['password']);

        }

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
    

}
