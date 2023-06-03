<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Interfaces\GetCustomQueryInterface;
use App\Interfaces\RepositoryInterface;
use Illuminate\Support\Facades\Auth;

class RecipeService
{
    private $recipeRepository;
    private $GetCustomQueryRecipeRepository;

    public function __construct(
        RepositoryInterface $recipeRepository,
        GetCustomQueryInterface $GetCustomQueryRecipeRepository
    )
    {
        $this->recipeRepository = $recipeRepository;
        $this->GetCustomQueryRecipeRepository = $GetCustomQueryRecipeRepository;
    }

    /**
     * method to list all recipes
     *
     * @return array
     */
    public function getRecipes()
    {
        $recipes = $this->recipeRepository->all();
        $processedRecipes = $this->processRecipes($recipes);
        return $processedRecipes;
    }

    /**
     * method to list all user recipes
     *
     * @return array
     */
    public function getUserRecipes()
    {
        $customColumn = 'user_id';
        $customValue = Auth::id();

        $userRecipes = $this->GetCustomQueryRecipeRepository->getCustomQueryColumn($customColumn, $customValue);
        $processedUserRecipes = $this->processRecipes($userRecipes);
        return $processedUserRecipes;
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

    private function processRecipes($recipes) {
        foreach ($recipes as &$recipe) {
            $recipe['ingredients'] = json_decode($recipe['ingredients']);
            $recipe['instructions'] = json_decode($recipe['instructions']);

            unset($recipe["created_at"]);
            unset($recipe["updated_at"]);
        }

        return $recipes;
    }
}
