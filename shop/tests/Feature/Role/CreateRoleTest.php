<?php

namespace Tests\Feature\Role;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Response;


class CreateRoleTest extends TestCase
{
    public function storeNewTagRoute ()
    {
        return route('roles.store');
    }

    public function createNewTagRoute ()
    {
        return route('roles.create');
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
    public function authenticated_user_can_create_new_role()
    {
    
        $this->actingAs(User::factory()->make());
        $role = Role::factory()->make()->toArray();
        $response = $this->post(route('roles.store', $role)); 

        $response->assertStatus(302);
        $this->assertDatabaseHas('roles', [
            'name' => $role['name'],
            'display_name'=>$role['display_name'],
            'group' => $role['group'],
        ]);
        $response->assertRedirect(route('roles.index'));
    }

    /**
     @test
     */
    public function unauthenticated_user_can_not_create_new_role(): void
    {
        $role = Role::factory()->make()->toArray();
        $response = $this->post(route('roles.store', $role));
        $response->assertRedirect('/login');

    }

    /**
     @test
     */
    public function authorized_user_can_not_create_new_role_if_name_field_is_null(): void
    { 
        $this->actingAs(User::factory()->make());
        $role = Role::factory()->make(['name' => null])->toArray();
        $response = $this->post(route('roles.store', $role));
        $response->assertSessionHasErrors('name');
    }
    /**
     @test
     */
    public function authorized_user_can_view_create_role_form ()    
    {
        $this->actingAs(User::factory()->make());
        $response = $this->get(route('roles.create'));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.role.create');
    }
    /**
     @test
     */
    public function authenticated_user_can_see_name_required_text_if_validate_error()
    {
        $this->actingAs(User::factory()->make());
        $role = Role::factory()->make(['name' => null])->toArray();
        $response=$this->from(route('roles.create'))->post(route('roles.store'),$role);
        $response->assertRedirect(route('roles.create'));

    }

    /**
     @test
     */
    public function unauthenticated_user_can_not_see_create_role_form_view ()
    {
        $response=$this->get(route('roles.create'));
        $response->assertRedirect('/login');
    }
    
}



