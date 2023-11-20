<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\User;

class DeleteProductTest extends TestCase
{
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
    public function authenticated_user_can_delete_category_if_category_exist(): void
    {   
        $user = User::factory()->make();
        $this->actingAs($user);

        $category = Category::factory()->create();
        $response = $this->delete(route('categories.destroy', $category->id));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
       
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect(route('categories.index'));            
       
    }
    /**
    @test
     */ 
    public function authenticated_user_can_not_delete_category_if_category_not_exist(): void
    {
        $user = User::factory()->make();
        $this->actingAs($user);

        $category_id= -1;
        $response = $this->delete(route('categories.destroy', $category_id));

        $response->assertStatus(Response::HTTP_NOT_FOUND);

    }
    /**
    @test
     */ 
    public function unauthenticated_user_can_not_delete_category(){
        $category = Category::factory()->create();
        $response = $this->delete(route('categories.destroy', $category->id));
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect(route('login'));

    }
}
