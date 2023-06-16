<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Repositories\RecipeRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RecipeService
{
    private $recipeRepository;

    public function __construct(RecipeRepository $recipeRepository)
    {
        $this->recipeRepository = $recipeRepository;
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
        $userRecipes = $this->recipeRepository->getUserRecipes(Auth::id());
        $processedUserRecipes = $this->processRecipes($userRecipes);
        return $processedUserRecipes;
    }

    /**
     * method to create a user recipe
     *
     * @param [type] $data
     */
    public function createRecipe($data)
    {
        $data['ingredients'] = json_encode($data['ingredients']);
        $data['instructions'] = json_encode($data['instructions']);

        $userId = Auth::id();
        $data['user_id'] = $userId;

        return $this->recipeRepository->create($data);
    }

        /**
     * method to create a user recipe
     *
     * @param [type] $data
     */
    public function searchRecipe($attributes)
    {
        try {
            $recipes = $this->recipeRepository->searchRecipe($attributes);

            // for (var key in obj) {
            //     newObj[key] = obj[key].replace(/\\/g, "/");
            //   }
            $processedUserRecipes = $this->processRecipes($recipes);
            return $processedUserRecipes;

        } catch (ModelNotFoundException $exception) {
            Log::error('Receita não encontrada.');
            throw new CustomException('Receita não encontrada.');
        }
    }

    /**
     * method to remove a user recipe
     *
     * @param [type] $id
     * @return void
     */
    public function deleteUuserRecipe($id)
    {
        try {
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
     *
     * @param [type] $id
     * @return void
     */
    public function updateUserRecipe($id, $data)
    {
        $data['ingredients'] = json_encode($data['ingredients']);
        $data['instructions'] = json_encode($data['instructions']);

        try {
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
