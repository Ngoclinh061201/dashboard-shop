<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\User;

class GetListProductTest extends TestCase
{
    public function getListProductRoute()
    {
        return route('products.index');
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
    public function unauthenticated_user_can_not_get_list_product(){
        $response = $this->get($this->getListProductRoute());
        $response->assertRedirect(route('login'));
    }
    
    /**
    @test
     */
    public function authenticated_user_can_get_list_product(){
        $user = User::factory()->make();
        $this->actingAs($user);

        $product = Product::factory()->create();
        $response = $this->get($this->getListProductRoute());
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.product.index');
        $response->assertSee($product->name); 
    }
     /**
    @test
    */
    public function authenticated_user_can_search_product(){
        $user = User::factory()->make();
        $this->actingAs($user);

        $product = Product::factory()->create();
        // dd($product);
        $searchTerm = $product->name;
        $response = $this->get('/products', ['search' => $searchTerm]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.product.index');
        $response->assertSee($product->name);

        
    }
    
}
