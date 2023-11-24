<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use App\Traits\HandleUpdateImageTrait;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Product extends Model
{
    use HasFactory, HandleUpdateImageTrait;
    protected $fillable = [
        'name',
        'description',
        'price',
        'sale',
    ];
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function scopeSearch($query, $key = null, $category = null)
    {
        return $query->when($key || $category, function($query) use ($key, $category) {
            // Nếu có giá trị cho $key hoặc $category, thêm điều kiện tìm kiếm
            $query->where(function($query) use ($key) {
                $query->where('name', 'like', '%' . $key . '%')
                    ->orWhere('description', 'like', '%' . $key . '%');
            })->when($category, function($query) use ($category) {
                // Nếu có giá trị cho $category, thêm điều kiện tìm kiếm theo danh mục sử dụng whereHas
                $query->whereHas('categories', function($query) use ($category) {
                    $query->where('categories.id', $category);
                });
            })->with(['images', 'categories']); // Sử dụng with để load các mối quan hệ images và categories
        });
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }
    public function getImageUrlAttribute()
    {
        if ($this->images->isNotEmpty()) {
            return'upload/' . $this->images->first()->url;
        } else {
            return asset('upload/default.png');
        }
    }
    
}
