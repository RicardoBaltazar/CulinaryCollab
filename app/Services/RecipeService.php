<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Interfaces\RepositoryInterface;
use Illuminate\Support\Facades\Auth;

class RecipeService
{
    private $recipeRepository;

    public function __construct(RepositoryInterface $recipeRepository)
    {
        $this->recipeRepository = $recipeRepository;
    }

    /**
     * method to list all recipes
     *
     * @return array
     */
    public function getRecipes()
    {
        $recipes = $this->recipeRepository->all();

        foreach ($recipes as $recipe) {
            $recipe['ingredients'] = json_decode($recipe['ingredients']);
            $recipe['instructions'] = json_decode($recipe['instructions']);
        }

        return $recipes;
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

        return $this->recipeRepository->create($data);
    }
}
