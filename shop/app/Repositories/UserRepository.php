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
        return $this->users->where('name', 'like', '%' . $searchTerm . '%')
            ->orWhere('email', 'like', '%' . $searchTerm . '%')
            ->orWhere('phone', 'like', '%' . $searchTerm . '%');
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
        $user =  $this->users->create($dataCreate->toArray());
        $user->images()->create(['url' => $dataCreate->get('image')]);
        $user->roles()->attach($dataCreate->toArray()['role_ids']);
        return $user;
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
        $dataObject = (object) $data;
        $currentImage = $user->images() ? $user->images()->latest()->first()->url : '';
        $data['image'] = $this->users->updateImage($dataObject, $currentImage);
        
        $user->update($data);
        $user->images()->delete();
        $user->images()->create(["url" => $data['image']]);

        if (isset($data['role_ids'])) {
            $user->roles()->sync($data['role_id']);
        }
    }
    
    public function delete(User $user)
    {
        $user->delete();
    }
    public function saveImage($request){
        return $this->users->saveImage($request);
    }
    
}
