<?php

namespace App\Service;

use App\Exception\UserAlreadyExistExeption;
use App\Exception\NotFoundException;
use App\Repository\UserRepository;
use App\Requests\User\AddUser;
use App\Requests\User\EditUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Service\Interface\IUserService;
use App\Adapter\UserAdapter;
use App\Message\Message;
use App\Entity\User as UserEntity;
use App\Response\ResponseBuilder;

class UserService implements IUserService
{
    private UserRepository $userRepository;

    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userRepository = $userRepository;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @param AddUser $userInput
     * @return JsonResponse
     */
    public function addUser(AddUser $userInput): JsonResponse
    {
        $this->findUserByEmail($userInput->email);
        $user =  UserAdapter::adapt($userInput);
        $user->setPassword($this->encryptPassword($user, $userInput->password));
        $this->userRepository->save($user, true);
        return ResponseBuilder::created($this->buildUserResponse($user));
    }

    /**
     * @param int $id
     * @param EditUser $editUser
     * @return JsonResponse
     */
    public function editUser(int $id, EditUser $editUser): JsonResponse
    {
        $user = $this->findUserById($id);
        $user->setPassword($this->encryptPassword($user, $editUser->password));
        $this->updateUserRecord($user);
        return ResponseBuilder::ok(Message::USER_UPDATE_USER);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteUser(int $id): JsonResponse
    {
        $user = $this->findUserById($id);
        $user->setStatus(UserEntity::STATUS_INACTIVE);
        $this->updateUserRecord($user);
        return ResponseBuilder::noContent();
    }


    public function findUserByEmail(string $email): void
    {
        $isUserFound = $this->userRepository->findUserByEmail($email);
        if(!empty($isUserFound)) {
            throw new UserAlreadyExistExeption(Message::USER_ALREADY_EXIST);
        }
    }

    /**
     * @param int $id
     * @return UserEntity
     */
    public function findUserById(int $id): UserEntity
    {
        $user = $this->userRepository->findUserById($id);
        if(empty($user)) {
            throw new NotFoundException(Message::USER_NOT_FOUND);
        }
        return $user;
    }

    /**
     * @param UserEntity $user
     * @param string $password
     * @return string
     */
    private function encryptPassword(UserEntity $user, string $password): string
    {
        return $this->userPasswordHasher->hashPassword($user, $password);
    }

    /**
     * @param UserEntity $user
     * @return array
     */
    private function buildUserResponse(UserEntity $user): array
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
        ];
    }

    /**
     * @param UserEntity $userEntity
     * @return void
     */
    private function updateUserRecord(UserEntity $userEntity): void
    {
        $userEntity->setUpdatedAt(new \DateTime());
        $this->userRepository->save($userEntity, true);
    }
}