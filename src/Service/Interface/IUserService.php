<?php

namespace App\Service\Interface;

use App\Requests\User\AddUser;
use App\Requests\User\EditUser;
use App\Entity\User as UserEntity;
use Symfony\Component\HttpFoundation\JsonResponse;

interface IUserService
{
    /**
     * @param AddUser $userInput
     * @return JsonResponse
     */
    public function addUser(AddUser $userInput): JsonResponse;

    /**
     * @param int $id
     * @param EditUser $editUser
     * @return JsonResponse
     */
    public function editUser(int $id, EditUser $editUser): JsonResponse;

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteUser(int $id): JsonResponse;

    /**
     * @param int $id
     * @return UserEntity
     */
    public function findUserById(int $id): UserEntity;
}