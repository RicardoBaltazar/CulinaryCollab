<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Interfaces\RepositoryInterface;
use Illuminate\Support\Facades\Auth;

class RecipeService
{
    private $recipeRepocitory;

    public function __construct(RepositoryInterface $recipeRepository)
    {
        $this->recipeRepocitory = $recipeRepository;
    }

    /**
     * method to create a user recipe
     *
     * @param [type] $data
     * @return void
     */
    public function createRecipe($data)
    {
        $data['ingredients'] = json_encode($data['ingredients']);
        $data['instructions'] = json_encode($data['instructions']);

        $userId = Auth::id();
        $data['user_id'] = $userId;

        return $this->recipeRepocitory->create($data);
    }
}
