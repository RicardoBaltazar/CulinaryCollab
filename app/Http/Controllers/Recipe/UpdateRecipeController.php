<?php

namespace App\Http\Controllers\Recipe;

use App\Http\Controllers\Controller;
use App\Services\RecipeService;
use Illuminate\Http\Request;

class UpdateRecipeController extends Controller
{
    private $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $data = $request->all();
        $this->recipeService->updateUserRecipe($id, $data);
        return response()->json('Receita atualizada com sucesso.');
    }
}
