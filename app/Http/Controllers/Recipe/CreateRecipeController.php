<?php

namespace App\Http\Controllers\Recipe;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeRequest;

class CreateRecipeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RecipeRequest $request)
    {
        $data = $request->all();

        $data['ingredients'] = json_encode($data['ingredients']);

        $data['ingredients'] = json_decode($data['ingredients']);
        return $data;
    }
}
