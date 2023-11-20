<?php

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\User;


class GetListCategoryTest extends TestCase


{
    public function getListCategoryRoute()
    {
        return route('categories.index');
    }
    
    public function setUp(): void
    {
        parent::setUp();

        // Bắt đầu một giao dịch trước khi chạy các test method
        DB::beginTransaction();
    }

    public function tearDown(): void
    {
        // Rollback giao dịch sau khi kết thúc mỗi test method
        DB::rollBack();

        parent::tearDown();
    }

    /**
     @test
     */
    public function unauthenticated_user_can_not_get_list_category(){
        $response = $this->get($this->getListCategoryRoute());
        $response->assertRedirect(route('login'));
    }
    
    /**
    @test
     */
    public function authenticated_user_can_get_list_category(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create();
        $response = $this->get($this->getListCategoryRoute());
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.category.index');
        $response->assertSee($category['name']); 
    }
     /**
    @test
    */
    // public function authenticated_user_can_search_category(){
    //     $user = User::factory()->make();
    //     $this->actingAs($user);

    //     $category = [
    //         'name' => $this->faker->unique()->word,
    //         'parent_id' => $this->faker->randomElement([NULL, 50, 52, 55]),
           
    //     ];
    //     $searchTerm = $category->name;
    //     $response = $this->get('/categories', ['search' => $searchTerm]);
    //     $response->assertStatus(Response::HTTP_OK);
    //     $response->assertViewIs('admin.pages.category.index');
    //     $response->assertSee($category->name);

        
    // }
    
}
