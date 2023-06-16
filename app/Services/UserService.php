<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Interfaces\RepositoryInterface;
use App\Repositories\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * method to register a new user
     *
     * @param array $data
     * @return void
     */
    public function createUser(array $data)
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
