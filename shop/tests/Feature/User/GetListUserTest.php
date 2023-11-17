<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class GetListUserTest extends TestCase

{
    public function getListUserRoute()
    {
        return route('users.index');
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
    public function unauthenticated_user_can_not_get_list_user(){
        $response = $this->get($this->getListUserRoute());
        $response->assertRedirect(route('login'));
    }
    
    /**
    @test
     */
    public function authenticated_user_can_get_list_user(){
        $user = User::factory()->make();
        $this->actingAs($user);

        $user = User::factory()->create();
        $response = $this->get($this->getListUserRoute());
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.user.index');
        $response->assertSee($user->name); 
    }
     /**
    @test
    */
    public function authenticated_user_can_search_user(){
        $user = User::factory()->make();
        $this->actingAs($user);

        $user = User::factory()->create();
        $searchTerm = $user->name;
        $response = $this->get('/users', ['search' => $searchTerm]);
        
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.user.index');
        $response->assertSee($user->name);
        $response->assertSee($user->display_name);
       
    }
    
}
