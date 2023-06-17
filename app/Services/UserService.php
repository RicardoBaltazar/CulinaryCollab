<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Repositories\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(array $data): string
    {
        try {
            $user = $this->userRepository->create($data);

            if(!$user)
            {
                new CustomException('it was not possible to register the new user');
            }

            return 'successfully registered user';

        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }
}
