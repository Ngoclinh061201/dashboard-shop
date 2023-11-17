<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class GetUserTest extends TestCase
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
    public function authenticated_user_can_get_user_if_user_exist(): void
    {   
        $user = User::factory()->make();
        $this->actingAs($user);

        $user = User::factory()->create();
        
        $response = $this->get(route('users.show', $user->id));

        $response->assertStatus(Response::HTTP_OK);

        
    }
    /**
    @test
     */ 
    public function authenticated_user_can_not_get_user_if_user_not_exist(): void
    {
        $user = User::factory()->make();
        $this->actingAs($user);

        $user_id = -1;
        $response = $this->get(route('users.show', $user_id));

        $response->assertStatus(Response::HTTP_NOT_FOUND);

    }
}

