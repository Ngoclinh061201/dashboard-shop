<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\User;

class UpdateProductTest extends TestCase
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

    public function editCategoryRoute($id)
    {
        
        return route('categories.edit', ['category' => $id]);
    }

    public function updateCategoryRoute($id)
    {
        return route('categories.update', ['category' => $id]);
    }
    /**
     @test
     */
    public function unauthenticated_user_can_not_see_edit_category_form_view(): void
    { 
        $category_id = 4;
        $response = $this->get($this->editCategoryRoute($category_id));
        
        $response->assertRedirect('/login');

    }

    /**
     @test
     */    
    public function authenticated_user_can_update_category_if_category_exists_and_data_is_valid()
    {

        $this->actingAs(User::factory()->make());
        $category = Category::factory()->create();
        
        $dataUpdate = [
            'name' => $this->faker->unique()->word,
            'parent_id' => $this->faker->randomElement([NULL, 50, 52, 55]),
           
        ];
        $response = $this->put($this->updateCategoryRoute($category->id), $dataUpdate);
        
        $response->assertStatus(Response::HTTP_FOUND);
        
        $this->assertDatabaseHas('categories',[
            'name' => $dataUpdate['name'],
            'parent_id' => $dataUpdate['parent_id'],
          
        ]);
    }

    /**
     @test
     */  
    public function authenticated_user_can_not_update_category_if_category_not_exists_and_data_is_valid()
    {
        $this->actingAs(User::factory()->make());
        $category_id = -1;
        $dataUpdate = [
            'name' => $this->faker->sentence,
            'parent_id' => $this->faker->randomElement([NULL, 50, 52, 55]),

            
        ];
        $response = $this->put($this->updateCategoryRoute($category_id), $dataUpdate);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
    /**
     @test
     */
    public function authenticated_user_can_not_update_category_if_category_exists_and_name_field_is_null()
    {
        $this->actingAs(User::factory()->make());
        $category = Category::factory()->create();
        $dataUpdate = [
            'name' => null,
            'parent_id' => $this->faker->randomElement([NULL, 50, 52, 55]),
        ];
        $response = $this->put($this->updateCategoryRoute($category->id), $dataUpdate);

        $response->assertSessionHasErrors('name');
        
    }

    /**
     @test
     */
    public function authenticated_user_can_update_category_if_category_exists_and_parent_id_field_is_null()
    {
        $this->actingAs(User::factory()->make());
        $category = Category::factory()->create();
        $dataUpdate = [
            'name' => $this->faker->sentence,
            'parent_id' => null,
        
        ];
        $response = $this->put($this->updateCategoryRoute($category->id), $dataUpdate);
        $response->assertStatus(Response::HTTP_FOUND);
        
        $this->assertDatabaseHas('categories',[
            'name' => $dataUpdate['name'],
            'parent_id' => $dataUpdate['parent_id'],
          
        ]);
        
    }

    
    

    /**
     @test
     */
   public function authenticated_user_can_see_edit_category_form_view () 
   {
        $this->actingAs(User::factory()->make());
        $category = Category::factory()->create();
        $response = $this->get($this->editCategoryRoute($category->id));
        $response->assertViewIs('admin.pages.category.edit');
   }
   
  

}
