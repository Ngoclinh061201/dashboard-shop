<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UpdateUserTest extends TestCase
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

    public function editUserRoute($id)
    {
        
        return route('users.edit', ['user' => $id]);
    }

    public function updateUserRoute($id)
    {
        return route('users.update', ['user' => $id]);
    }
    /**
     @test
     */
    public function unauthenticated_user_can_not_see_edit_user_form_view(): void
    { 
        $user_id = 1;
        $response = $this->get($this->editUserRoute($user_id));
        
        $response->assertRedirect('/login');

    }

    /**
     @test
     */    
    public function authenticated_user_can_update_user_if_user_exists_and_data_is_valid()
    {

        $this->actingAs(User::factory()->make());
        $user = User::factory()->create();
        $dataUpdate = [
            'name' => $this->faker->word,
            'email'=> $this->faker->unique()->email,
            'phone'=> $this->faker->unique()->phoneNumber,
            'address'=> $this->faker->sentence,
            'gender'=> $this->faker->word,

        ];
        $response = $this->put($this->updateUserRoute($user->id), $dataUpdate);
        
        $response->assertStatus(Response::HTTP_FOUND);
        
        $this->assertDatabaseHas('users',[
            'name' => $dataUpdate['name'],
            'email'=> $dataUpdate['email'], 
            'phone'=> $dataUpdate['phone'], 
            'address'=> $dataUpdate['address'], 
            'gender'=> $dataUpdate['gender'], 
        ]);
    }

    /**
     @test
     */  
    public function authenticated_user_can_not_update_user_if_user_not_exists_and_data_is_valid()
    {
        $this->actingAs(User::factory()->make());
        $user_id = -1;
        $dataUpdate = [
            'name' => $this->faker->unique()->word,
            'email'=> $this->faker->unique()->email,
            'phone'=> $this->faker->unique()->phoneNumber,
        ];
        $response = $this->put($this->updateUserRoute($user_id), $dataUpdate);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
    /**
     @test
     */
    public function authenticated_user_can_not_update_user_if_user_exists_and_name_field_is_null()
    {
        $this->actingAs(User::factory()->make());
        $user = User::factory()->create();
        $dataUpdate = [
            'name' => null,
            'email'=> $this->faker->unique()->email,
            'phone'=> $this->faker->unique()->phoneNumber,
        ];
        $response = $this->put($this->updateUserRoute($user->id), $dataUpdate);

        $response->assertSessionHasErrors('name');
        
    }

    /**
     @test
     */
    public function authenticated_user_can_not_update_user_if_user_exists_and_phone_field_is_null()
    {
        $this->actingAs(User::factory()->make());
        $user = User::factory()->create();
        $dataUpdate = [
            'name' => $this->faker->unique()->word,
            'email'=> $this->faker->unique()->email,
            'phone'=> null,
        ];
        $response = $this->put($this->updateUserRoute($user->id), $dataUpdate);

        $response->assertSessionHasErrors('phone');
        
    }

    /**
     @test
     */
    public function authenticated_user_can_not_update_user_if_user_exists_and_email_field_is_null()
    {
        $this->actingAs(User::factory()->make());
        $user = User::factory()->create();
        $dataUpdate = [
            'name' => $this->faker->unique()->word,
            'email'=> null,
            'phone'=> $this->faker->unique()->phoneNumber,
        ];
        $response = $this->put($this->updateUserRoute($user->id), $dataUpdate);
        $response->assertSessionHasErrors('email');
        
    }

    

    /**
     @test
     */

     public function authenticated_user_can_not_update_user_if_user_exists_and_data_is_null ()
     {
        $this->actingAs(User::factory()->make());
         $user = User::factory()->create();
         $dataUpdate = [
             'name' => null,
             'email' => null,
             'phone' => null,
         ];
         $response = $this->put($this->updateUserRoute($user->id), $dataUpdate);

         $response->assertSessionHasErrors('name');
         $response->assertSessionHasErrors('email');
         $response->assertSessionHasErrors('phone');
         
         
     }

    /**
     @test
     */
   public function authenticated_user_can_see_edit_user_form_view () 
   {
        $this->actingAs(User::factory()->make());
        $user = User::factory()->create();
        $response = $this->get($this->editUserRoute($user->id));
        $response->assertViewIs('admin.pages.user.edit');
   }
   
  

}
