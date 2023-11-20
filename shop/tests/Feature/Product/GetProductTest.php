<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\User;

class GetProductTest extends TestCase
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
    public function authenticated_user_can_get_category_if_role_exist(): void
    {   
        $user = User::factory()->make();
        $this->actingAs($user);

        $category = Category::factory()->create();
        $response = $this->get(route('categories.show', $category->id));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.category.show');

        
    }
    /**
    @test
     */ 
    public function authenticated_user_can_not_get_category_if_role_not_exist(): void
    {
        $user = User::factory()->make();
        $this->actingAs($user);

        $category_id = -1;
        $response = $this->get(route('categories.show', $category_id));

        $response->assertStatus(Response::HTTP_NOT_FOUND);

    }

      /**
     @test
     */
    public function unauthenticated_user_can_not_get_category(){
        $category = Category::factory()->create();
        $response = $this->get(route('categories.show', $category->id));
        $response->assertRedirect(route('login'));
    }
}
