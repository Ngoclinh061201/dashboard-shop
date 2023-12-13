<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class ProductRepository
{
    protected $products;

    public function __construct(Product $products)
    {
        $this->products = $products;
    }

    public function searchProducts($key, $category)
    {
        $products= $this->products->search($key, $category);
        return $products = $this->paginateProducts($products, 5);
    }

    public function latestproducts()
    {
        return $this->products->with(['categories', 'images'])->latest('updated_at');
    }

    public function paginateProducts($products, $perPage)
    {
        return $products->paginate($perPage);
    }

    public function create($dataCreate)
    {
        $product =  $this->products->create($dataCreate);
        return $product;
    }

    public function getByIdWithRelationships(string $id)
    {
        return $this->products->with(['categories', 'images'])->findOrFail($id);
    }
    
    public function getProductWithCategories(string $id)
    {
        return $this->products->with('categories')->findOrFail($id);
    }

    public function update(Product $product, array $data)
    {
        $product = $product->update($data);
        return $product;
    }
    
    public function delete(Product $product)
    {
        $product->delete();
    }

    public function saveImage($request){
        return $this->products->saveImage($request);
    }
}
