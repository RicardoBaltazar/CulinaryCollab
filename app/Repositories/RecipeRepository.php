<?php

namespace App\Repositories;

use App\Interfaces\GetCustomQueryInterface;
use App\Interfaces\RepositoryInterface;
use App\Models\Recipe;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class RecipeRepository implements RepositoryInterface, GetCustomQueryInterface
{
    protected $recipeModel;

    public function __construct(Recipe $recipeModel)
    {
        $this->recipeModel = $recipeModel;
    }

    public function all()
    {
        try {
            return $this->recipeModel->all();

        } catch (Exception $e) {
            $errorMessage = 'Internal server error: ' . $e->getMessage();
            Log::error($errorMessage);
            return response()->json([
                'message' => 'Failed to retrieve recipes',
                'error' => $errorMessage
            ], 500);
        }
    }

    public function create(array $attributes)
    {
        try {
            $newData = $this->recipeModel->create($attributes);
            return response()->json([
                'message' => 'successfully registered recipe',
                'recipe_title' => $newData['title'],
            ]);

        } catch (Exception $e) {
            $errorMessage = 'Internal server error: ' . $e->getMessage();
            Log::error($errorMessage);
            return response()->json([
                'message' => 'Failed to create the new recipe',
                'error' => $errorMessage
            ], 500);
        }
    }

    public function find(int $id)
    {
        Log::info('Receita encontrada.');
        return $this->recipeModel->findOrFail($id);
    }

    public function delete(int $id)
    {
        $recipe = $this->recipeModel->findOrFail($id);
        Log::info('Usuário excluído com sucesso.');
        return $recipe->delete();
    }

    public function update(int $id, array $attributes)
    {
        return $this->returnResponse();
    }

    public function getCustomQueryColumn($column, $value)
    {
        return $this->recipeModel->where($column, $value)->get();
    }

    private function returnResponse()
    {
        return response()->json('This functionality is still under development.', 501);
    }
}
