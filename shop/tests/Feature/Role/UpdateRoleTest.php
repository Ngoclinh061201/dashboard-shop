<?php

namespace Tests\Feature\Role;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;

class UpdateRoleTest extends TestCase
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

    public function editRoleRoute($id)
    {
        return route('roles.edit', ['id' => $id]);
    }

    public function updateRoleRoute($id)
    {
        return route('roles.update', ['id' => $id]);
    }
    /**
     @test
     */
    public function unauthenticated_user_can_not_see_edit_role_form_view(): void
    { 
        $role = Role::factory()->create();
        $response = $this->get($this->editRoleRoute($role->id));
        $response->assertRedirect('/login');
    }

    /**
     @test
     */    
    public function authenticated_user_can_update_role_if_role_exists_and_data_is_valid()
    {
        $this->actingAs(User::factory()->make());
        $role = Role::factory()->create();
        $dataUpdate = [
            'name' => $this->faker->unique()->word,
            'display_name' => $this->faker->word,
            'group' => $this->faker->word,
        ];
       
        $response = $this->put($this->updateRoleRoute($role->id), $dataUpdate);
        
        $response->assertStatus(Response::HTTP_FOUND);
        
        $this->assertDatabaseHas('roles',[
            'name' => $dataUpdate['name'],
            'display_name' => $dataUpdate['display_name'],
            'group' => $dataUpdate['group'],
        ]);
    }

    /**
     @test
     */  
    public function authenticated_user_can_not_update_role_if_role_not_exists_and_data_is_valid()
    {
        $this->actingAs(User::factory()->make());
        $role_id = -1;
        $dataUpdate = [
            'name' => $this->faker->sentence,
            'display_name' => $this->faker->paragraph,
            'group' => $this->faker->regexify('^[0-9]{10}'),
        ];
        $response = $this->put($this->updateRoleRoute($role_id), $dataUpdate);

        $response->assertStatus(500);
    }
    /**
     @test
     */
    public function authenticated_user_can_not_update_role_if_role_exists_and_name_field_is_null()
    {
        $this->actingAs(User::factory()->make());
        $role = Role::factory()->create();
        $dataUpdate = [
            'name' => null,
            'display_name' => $this->faker->paragraph,
            'group' => $this->faker->regexify('^[0-9]{10}'),
        ];
        $response = $this->put($this->updateRoleRoute($role->id), $dataUpdate);

        $response->assertSessionHasErrors('name');
        
    }

    /**
     @test
     */
    public function authenticated_user_can_not_update_role_if_role_exists_and_display_name_field_is_null()
    {
        $this->actingAs(User::factory()->make());
        $role = Role::factory()->create();
        $dataUpdate = [
            'name' => $this->faker->sentence,
            'display_name' => null,
            'group' => $this->faker->regexify('^[0-9]{10}'),
        ];
        $response = $this->put($this->updateRoleRoute($role->id), $dataUpdate);

        $response->assertSessionHasErrors('display_name');
        
    }

    /**
     @test
     */
    public function authenticated_user_can_not_update_role_if_role_exists_and_group_field_is_null()
    {
        $this->actingAs(User::factory()->make());
        $role = Role::factory()->create();
        $dataUpdate = [
            'name' => $this->faker->sentence,
            'display_name' => $this->faker->paragraph,
            'group' => '12345'
        ];
        $response = $this->put($this->updateRoleRoute($role->id), $dataUpdate);
        $response->assertSessionHasErrors('group');
        
    }

    /**
     @test
     */

     public function authenticated_user_can_not_update_role_if_role_exists_and_data_is_null ()
     {
        $this->actingAs(User::factory()->make());
         $role = Role::factory()->create();
         $dataUpdate = [
             'name' => null,
             'display_name' => null,
             'group' => null,
         ];
         $response = $this->put($this->updateRoleRoute($role->id), $dataUpdate);

         $response->assertSessionHasErrors('name');
         $response->assertSessionHasErrors('display_name');
         $response->assertSessionHasErrors('group');
         
         
     }

    /**
     @test
     */
   public function authenticated_user_can_see_edit_role_form_view () 
   {
        $this->actingAs(User::factory()->make());
        $role = Role::factory()->create();
        $response = $this->get($this->editRoleRoute($role->id));
        $response->assertViewIs('roles.edit');
   }
   
  

}
