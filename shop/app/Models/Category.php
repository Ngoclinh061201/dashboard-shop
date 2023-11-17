<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'parent_id',
    ];
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
                
        });
    }
    public function parent(){
        
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function childrens(){
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function getParentNameAttribute(){
       
         return optional($this->parent)->name;
    }
    public function getParents(){
      
        return Category::where('parent_id', 0)->get(['id','name']);
    }
}
