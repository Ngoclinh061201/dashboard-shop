<?php

namespace Tests\Feature\Role;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\http\Response;
use Illuminate\Support\Facades\DB;


class GetListRoleTest extends TestCase


{
    public function getListRoleRoute()
    {
        return route('roles.index');
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
    public function unauthenticated_user_can_not_get_list_role(){
        $response = $this->get($this->getListRoleRoute());
        $response->assertRedirect(route('login'));
    }
    
    /**
    @test
     */
    public function authenticated_user_can_get_list_role(){
        $user = User::factory()->make();
        $this->actingAs($user);

        $role = Role::factory()->create();
        $response = $this->get($this->getListRoleRoute());
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.role.index');
        $response->assertSee($role->name); 
    }
     /**
    @test
    */
    public function authenticated_user_can_search_role(){
        $user = User::factory()->make();
        $this->actingAs($user);

        $role = Role::factory()->create();
        $searchTerm = $role->name;
        $response = $this->get('/roles', ['search' => $searchTerm]);
        
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.pages.role.index');
        $response->assertSee($role->name);
        $response->assertSee($role->display_name);
       
    }
    
}
