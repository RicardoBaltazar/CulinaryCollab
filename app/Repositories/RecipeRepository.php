<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use App\Models\Recipe;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Throwable;

class RecipeRepository implements RepositoryInterface
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
                'message' => 'Failed to create the new recipe',
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
        return $this->returnResponse();

    }

    public function delete(int $id)
    {
        return $this->returnResponse();

    }

    public function update(int $id, array $attributes)
    {
        return $this->returnResponse();

    }

    private function returnResponse()
    {
        return response()->json('This functionality is still under development.', 501);
    }
}
