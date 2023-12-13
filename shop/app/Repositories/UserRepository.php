<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected $users;

    public function __construct(User $users)
    {
        $this->users = $users;
    }

    public function searchUsers($searchTerm)
    {
        $users= $this->users->search($searchTerm);
        return $users = $this->paginateUsers($users, 5);
    }

    public function latestusers()
    {
        return $this->users->latest('updated_at');
    }

    public function paginateUsers($users, $perPage)
    {
        return $users->paginate($perPage);
    }

    public function create($dataCreate)
    {
        return $user =  $this->users->create($dataCreate);
    }

    public function getById(string $id)
    {
        return $this->users->findOrFail($id);
    }

    public function getUserWithRoles(string $id)
    {
        return $this->users->with('roles')->findOrFail($id);
    }

    public function update(User $user, array $data)
    {
        $user = $user->update($data);
        return $user;
    }
    
    public function delete(User $user)
    {
        $user->delete();
    }

    public function saveImage($request){
        return $this->users->saveImage($request);
    } 
}
