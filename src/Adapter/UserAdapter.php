<?php

namespace App\Adapter;

use App\Entity\User as UserEntity;
use App\Requests\User\AddUser;

class UserAdapter
{
    public static function adapt(AddUser $user) : UserEntity
    {
        $dateTime = new \DateTime();
        $userEntity = new UserEntity();
        $userEntity->setEmail($user->email);
        $userEntity->setRoles('ROLE_'.strtoupper($user->role));
        $userEntity->setStatus(UserEntity::STATUS_ACTIVE);
        $userEntity->setCreatedAt($dateTime);
        $userEntity->setUpdatedAt($dateTime);
        return $userEntity;
    }

}