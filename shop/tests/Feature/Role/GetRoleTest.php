<?php

namespace Tests\Feature\Role;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use Illuminate\http\Response;


class GetRoleTest extends TestCase
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
    public function authenticated_user_can_get_role_if_role_exist(): void
    {   
        $user = User::factory()->make();
        $this->actingAs($user);

        $role = Role::factory()->create();
        $response = $this->get(route('roles.show', $role->id));

        $response->assertStatus(Response::HTTP_OK);

        
    }
    /**
    @test
     */ 
    public function authenticated_user_can_not_get_role_if_role_not_exist(): void
    {
        $user = User::factory()->make();
        $this->actingAs($user);

        $role_id = -1;
        $response = $this->get(route('roles.show', $role_id));

        $response->assertStatus(Response::HTTP_NOT_FOUND);

    }
}
