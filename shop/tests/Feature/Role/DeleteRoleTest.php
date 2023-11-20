<?php

namespace Tests\Feature\Role;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Response;


class DeleteRoleTest extends TestCase {
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
    public function authenticated_user_can_delete_role_if_role_exist(): void
    {   
        $user = User::factory()->make();
        $this->actingAs($user);

        $role = Role::factory()->create();
        $response = $this->delete(route('roles.destroy', $role->id));
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
       
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect(route('roles.index'));            
       
    }
    /**
    @test
     */ 
    public function authenticated_user_can_not_delete_role_if_role_not_exist(): void
    {
        $user = User::factory()->make();
        $this->actingAs($user);

        $role_id= -1;
        $response = $this->delete(route('roles.destroy', $role_id));

        $response->assertStatus(Response::HTTP_NOT_FOUND);

    }
    /**
    @test
     */ 
    public function unauthenticated_user_can_not_delete_role(){
        $role = Role::factory()->create();
        $response = $this->delete(route('roles.destroy', $role->id));
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect(route('login'));

    }
}
