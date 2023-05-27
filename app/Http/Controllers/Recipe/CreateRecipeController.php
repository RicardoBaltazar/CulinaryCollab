<?php

namespace App\Http\Controllers\Recipe;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeRequest;
use App\Services\RecipeService;

class CreateRecipeController extends Controller
{
    private $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(RecipeRequest $request)
    {
        $data = $request->all();

        return $this->recipeService->createRecipe($data);
    }
}
