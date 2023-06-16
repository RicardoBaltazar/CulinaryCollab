<?php

namespace App\Repositories;

use App\Models\Recipe;

class RecipeRepository extends BaseRepository
{
    protected $recipe;

    public function __construct(Recipe $recipe)
    {
        parent::__construct(New Recipe());

        $this->recipe = $recipe;
    }

    public function getUserRecipes($id)
    {
        return $this->recipe->getUserRecipes($id);
    }

    public function searchRecipe($attributes)
    {
        return $this->recipe->searchRecipe($attributes);
    }
}
