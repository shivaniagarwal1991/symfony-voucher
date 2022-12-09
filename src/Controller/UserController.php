<?php

namespace App\Controller;

use App\Requests\User\EditUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Interface\IUserService;
use App\Requests\User\AddUser;

/**
 * @Route("/voucher/user")
 */
class UserController extends AbstractController
{
    protected IUserService $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/add', name: 'add_user', methods: 'POST')]

    public function addUser(AddUser $userInput): JsonResponse
    {
        return $this->userService->addUser($userInput);
    }

    #[Route('/update/{id}', name: 'edit_user', methods: 'PUT')]

    public function editUser(EditUser $user, int $id): JsonResponse
    {
        return $this->userService->editUser($id, $user);
    }

    #[Route('/{id}', name: 'delete_user', methods: 'DELETE')]

    public function deleteUser(int $id): JsonResponse
    {
        return $this->userService->deleteUser($id);
    }

}