<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CreateUserTest extends TestCase
{
public function storeNewUserRoute ()
    {
        return route('users.store');
    }

    public function createNewUserRoute ()
    {
        return route('users.create');
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
    public function authenticated_user_can_create_new_user()
    {
    
        $this->actingAs(User::factory()->make());
        $user = User::factory()->create()->toArray();
        $response = $this->post(route('users.store', $user)); 

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseHas('users', [
            'name' => $user['name'],
            'email'=> $user['email'], 
            'phone'=> $user['phone'], 
            'address'=> $user['address'], 
            'gender'=> $user['gender'], 
        ]);
       
       
    }

    /**
     @test
     */
    public function unauthenticated_user_can_not_create_new_user(): void
    {
        $user = User::factory()->make()->toArray();
        $response = $this->post(route('users.store', $user));
        $response->assertRedirect('/login');

    }

    /**
     @test
     */
    public function authorized_user_can_not_create_new_user_if_name_field_is_null(): void
    { 
        $this->actingAs(User::factory()->make());
        $user = User::factory()->make(['name' => null])->toArray();
        $response = $this->post(route('users.store', $user));
        $response->assertSessionHasErrors('name');
    }
    /**
     @test
     */
    public function authorized_user_can_view_create_user_form ()    
    {
        $this->actingAs(User::factory()->make());
        $response = $this->get(route('users.create'));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.user.create');
    }
    /**
     @test
     */
    public function authenticated_user_can_see_name_required_text_if_validate_error()
    {
        $this->actingAs(User::factory()->make());
        $user = User::factory()->make(['name' => null])->toArray();
        $response=$this->from(route('users.create'))->post(route('users.store'),$user);
        $response->assertRedirect(route('users.create'));

    }

    /**
     @test
     */
    public function unauthenticated_user_can_not_see_create_user_form_view ()
    {
        $response=$this->get(route('users.create'));
        $response->assertRedirect('/login');
    }
    /**
     @test
     */
    public function authorized_user_can_not_create_new_user_if_image_field_is_null(): void
    { 
        $this->actingAs(User::factory()->make());
        $user = User::factory()->make(['image' => null])->toArray();
        $response = $this->post(route('users.store', $user));
        $response->assertSessionHasErrors('image');
    }
    /**
     @test
     */
    public function authorized_user_can_not_create_new_user_if_email_field_is_null(): void
    { 
        $this->actingAs(User::factory()->make());
        $user = User::factory()->make(['email' => null])->toArray();
        $response = $this->post(route('users.store', $user));
        $response->assertSessionHasErrors('email');
    }
    /**
     @test
     */
    public function authorized_user_can_not_create_new_user_if_password_field_is_null(): void
    { 
        $this->actingAs(User::factory()->make());
        $user = User::factory()->make(['password' => null])->toArray();
        $response = $this->post(route('users.store', $user));
        $response->assertSessionHasErrors('password');
    }
    /**
     @test
     */
    public function authorized_user_can_not_create_new_user_if_phone_field_is_null(): void
    { 
        $this->actingAs(User::factory()->make());
        $user = User::factory()->make(['phone' => null])->toArray();
        $response = $this->post(route('users.store', $user));
        $response->assertSessionHasErrors('phone');
    }
}
