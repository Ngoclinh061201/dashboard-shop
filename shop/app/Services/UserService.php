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

    public function searchUsers($searchTerm){
        $Users = $this->userRepository->searchUsers($searchTerm);
        return $this->userRepository->paginateUsers($Users, 5);

    }

    public function createUser( $request)
    {
        $dataCreate = $request;
        $dataCreate['password'] = Hash::make($request->password);
        $dataCreate['image'] = $this->userRepository->saveImage($request);
        $user = $this->userRepository->create($dataCreate);
        

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
        $user = $this->userRepository->getById($id);
        $this->userRepository->delete($user);

    }
    public function updateUser(string $id, array $data){
        $dataUpdate = Arr::except($data, ['password']);
        $dataUpdate['password'] = Hash::make($data['password']);
        $user = $this->userRepository->getuserWithRoles($id);
       
        $user = $this->userRepository->update($user, $dataUpdate);
        return $user;
    }

}
