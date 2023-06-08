<?php

namespace App\Http\Controllers\Recipe;

use App\Http\Controllers\Controller;
use App\Services\RecipeService;

class DeleteRecipeController extends Controller
{
    private $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        $this->recipeService->deleteUuserRecipe($id);
        return response()->json('Receita removida com sucesso.');
    }
}
