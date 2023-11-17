<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;


class UserService
{
    protected $userRepository;
    protected $permissionRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getLatestUsers()
    {
        $Users = $this->userRepository->latestUsers();

        return $this->userRepository->paginateUsers($Users, 5);
    }

    public function searchUsers($searchTerm)
    {
        return $this->userRepository->searchUsers($searchTerm);
    }

    public function createUser( $request)
    {
       
        $dataCreate = $request->all();
        $dataCreate['password'] = Hash::make($request->password);
        $dataCreate['image'] = $this->userRepository->saveImage($request);
        $user = $this->userRepository->create($dataCreate);
        $user->images()->create(["url" => $dataCreate['image']]);

        if (isset($dataCreate['role_ids'])) {
            $user->roles()->attach($dataCreate['role_ids']);
        }
        

    }
    public function getUserById(string $id)
    {
        return $this->userRepository->getById($id);
    }
    public function getUserWithRoles(string $id)
    {
        return $this->userRepository->getUserWithRoles($id);
    }
    
    public function deleteUser(string $id)
    {
        $user = $this->userRepository->getUserWithRoles($id);
        $currentImage = $user->images()->count() > 0 ? $user->images()->first()->url : '';
        $user->images()->delete();
        $user->deleteImage($currentImage);
        $this->userRepository->delete($user);

    }
    public function updateUser(string $id, $request){
        
        $dataUpdate = $request->except('password');
        $user = $this->userRepository->getUserWithRoles($id);
        if($request->password){
            $dataUpdate['password'] = Hash::make($request['password']);

        }

        $currentImage = $user->images()->count()>0 ? $user->images()->first()->url : '';
        $dataUpdate['image'] = $user->updateImage($request, $currentImage);

        $user->images()->delete();
        $user->images()->create(["url" => $dataUpdate['image']]);

        if (isset($dataUpdate['role_ids'])) {
            $user->roles()->sync($dataUpdate['role_ids']);
        }
        $user = $this->userRepository->update($user, $dataUpdate);
        return $user;
    }

}
