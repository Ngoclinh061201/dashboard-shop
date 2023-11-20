<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\User;

class CreateProductTest extends TestCase
{
    public function storeNewcategoryRoute ()
    {
        return route('categories.store');
    }

    public function createNewcategoryRoute ()
    {
        return route('categories.create');
    }

    public function setUp(): void
    {
        parent::setUp();

        DB::beginTransaction();
    }

    public function tearDown(): void
    {
       
        DB::rollBack();

        parent::tearDown();
    }
    /**
     @test
     */
    public function authenticated_user_can_create_new_category()
    {
    
        $this->actingAs(User::factory()->make());
        $category = Category::factory()->make()->toArray();
        $response = $this->post(route('categories.store', $category)); 

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseHas('categories', [
            'name' => $category['name'],
            'parent_id'=>$category['parent_id'],
          
        ]);
        $response->assertRedirect(route('categories.index'));
    }

    /**
     @test
     */
    public function unauthenticated_user_can_not_create_new_category(): void
    {
        $category = Category::factory()->make()->toArray();
        $response = $this->post(route('categories.store', $category));
        $response->assertRedirect('/login');

    }

    /**
     @test
     */
    public function authorized_user_can_not_create_new_category_if_name_field_is_null(): void
    { 
        $this->actingAs(User::factory()->make());
        $category = Category::factory()->make(['name' => null])->toArray();
        $response = $this->post(route('categories.store', $category));
        $response->assertSessionHasErrors('name');
    }
    /**
     @test
     */
    public function authorized_user_can_view_create_category_form ()    
    {
        $this->actingAs(User::factory()->make());
        $response = $this->get(route('categories.create'));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.category.create');
    }
    /**
     @test
     */
    public function authenticated_user_can_see_name_required_text_if_validate_error()
    {
        $this->actingAs(User::factory()->make());
        $category = Category::factory()->make(['name' => null])->toArray();
        $response=$this->from(route('categories.create'))->post(route('categories.store'),$category);
        $response->assertRedirect(route('categories.create'));

    }

    /**
     @test
     */
    public function unauthenticated_user_can_not_see_create_category_form_view ()
    {
        $response=$this->get(route('categories.create'));
        $response->assertRedirect('/login');
    }
    
}
