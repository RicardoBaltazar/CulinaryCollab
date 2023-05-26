<?php

namespace App\Services;

use App\Interfaces\RepositoryInterface;

class UserService
{
    private $userRepository;

    public function __construct(RepositoryInterface $userRepository)
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
        return $this->userRepository->create($data);
    }
}
