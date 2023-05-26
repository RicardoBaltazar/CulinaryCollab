<?php

namespace  App\Repositories;

use App\Interfaces\RepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserRepository implements RepositoryInterface
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function all()
    {
        return $this->returnResponse();
    }

    public function create(array $attributes)
    {
        try {
            $this->userModel->create($attributes);
            return response()->json('successfully registered user');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json('it was not possible to register the new user', 401);
        }
    }

    public function find(int $id)
    {
        return $this->returnResponse();

    }

    public function delete(int $id)
    {
        return $this->returnResponse();

    }

    public function update(int $id, array $attributes)
    {
        return $this->returnResponse();

    }

    private function returnResponse()
    {
        return response()->json('This functionality is still under development.', 501);
    }
}
