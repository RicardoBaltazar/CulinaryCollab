<?php

namespace App\Http\Controllers\Recipe;

use App\Http\Controllers\Controller;
use App\Services\RecipeService;

class GetRecipeController extends Controller
{
    private $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $recipes = $this->recipeService->getRecipes();
        return response()->json($recipes, 200, [], JSON_UNESCAPED_SLASHES);
    }
}
