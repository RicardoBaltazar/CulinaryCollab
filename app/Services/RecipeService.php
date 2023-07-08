<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Jobs\CreateRecipeJob;
use App\Jobs\CreateRecipeNotificationJob;
use App\Notifications\CreateRecipeNotification;
use App\Repositories\RecipeRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class RecipeService
{
    private $recipeRepository;

    public function __construct(RecipeRepository $recipeRepository)
    {
        $this->recipeRepository = $recipeRepository;
    }

    /**
     * method to list all recipes
     */
    public function getRecipes()
    {
        $processedRecipes = Cache::remember('recipes', 60 * 60, function () {
            $recipes = $this->recipeRepository->all();

            Log::info('querying whitout cache');
            return $this->processRecipes($recipes);
        });

        Log::info('querying list of recipes');

        return $processedRecipes;
    }

    /**
     * method to list all user recipes
     */
    public function getUserRecipes()

    {
        $processedUserRecipes = Cache::remember('userRecipes', 60 * 60, function () {
            $userRecipes = $this->recipeRepository->getUserRecipes(Auth::id());

            Log::info('querying whitout cache');
            return $this->processRecipes($userRecipes);
        });

        Log::info('querying list of user recipes');

        return $processedUserRecipes;
    }

    /**
     * method to create a user recipe
     */
    public function createRecipe($data)
    {
        $data['ingredients'] = json_encode($data['ingredients']);
        $data['instructions'] = json_encode($data['instructions']);

        $userId = Auth::id();
        $data['user_id'] = $userId;

        try {
            dispatch(new CreateRecipeJob($data));
            dispatch(new CreateRecipeNotificationJob($userId));

            Cache::forget('recipes');
            Cache::forget('userRecipes');

            return 'Receita criada com sucesso!';

        } catch (ModelNotFoundException $exception) {
            Log::error('Erro ao tentar registrar uma nova receita');
            throw new CustomException($exception->getMessage());
        }
    }

    /**
     * method to search a recipe
     */
    public function searchRecipe($attributes)
    {
        try {
            $recipes = $this->recipeRepository->searchRecipe($attributes);

            if($recipes->isEmpty())
            {
                return 'Nenhuma receita encontrada';
            }

            $processedUserRecipes = $this->processRecipes($recipes);
            return $processedUserRecipes;

        } catch (ModelNotFoundException $exception) {
            Log::error('Erro ao pesquisar receita');
            throw new CustomException($exception->getMessage());
        }
    }

    /**
     * method to remove a user recipe
     */
    public function deleteUuserRecipe($id)
    {
        try {
            Cache::forget('recipes');
            Cache::forget('userRecipes');

            $this->recipeRepository->delete($id);
            Log::error('Receita removida com sucesso.');

        } catch (ModelNotFoundException $exception) {
            Log::error('Receita não encontrada.');
            throw new CustomException('Receita não encontrada.');
        } catch (\Exception $exception) {
            throw new CustomException('Ocorreu um erro ao excluir a receita.');
        }
    }

    /**
     * method to update a user recipe
     */
    public function updateUserRecipe($id, $data)
    {
        $data['ingredients'] = json_encode($data['ingredients']);
        $data['instructions'] = json_encode($data['instructions']);

        try {
            Cache::forget('recipes');
            Cache::forget('userRecipes');

            $this->recipeRepository->update($id, $data);
            Log::error('Receita atualizada com sucesso.');

        } catch (ModelNotFoundException $exception) {
            Log::error('Receita não encontrada.');
            throw new CustomException('Receita não encontrada.');
        } catch (\Exception $exception) {
            throw new CustomException('Ocorreu um erro ao atualizar a receita.');
        }
    }

    /**
     *Process the recipes by decoding JSON fields and removing unnecessary keys.
     *
     * @param array
     * @return array
     */
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
