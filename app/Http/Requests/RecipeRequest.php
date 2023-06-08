<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class RecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.name' => 'required|string',
            'ingredients.*.quantity' => 'required|string',
            'instructions' => 'required|array|min:1',
            'instructions.*.step' => 'required|integer',
            'instructions.*.description' => 'required|string',
            'category' => 'required|string|in:Entradas,Bebidas,Pães,Café da Manhã,Sobremesas,Pratos Principais,Saladas,Acompanhamentos,Sopas,Vegetariano/Vegano',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title field must be a string.',
            'ingredients.required' => 'The ingredients field is required.',
            'ingredients.array' => 'The ingredients field must be an array.',
            'ingredients.min' => 'The ingredients field must have at least one item.',
            'ingredients.*.name.required' => 'Each ingredient must have a name.',
            'ingredients.*.name.string' => 'The ingredient name must be a string.',
            'ingredients.*.quantity.required' => 'Each ingredient must have a quantity.',
            'ingredients.*.quantity.string' => 'The ingredient quantity must be a string.',
            'instructions.required' => 'The instructions field is required.',
            'instructions.array' => 'The instructions field must be an array.',
            'instructions.min' => 'The instructions field must have at least one item.',
            'instructions.*.step.required' => 'Each instruction must have a step number.',
            'instructions.*.step.integer' => 'The instruction step number must be an integer.',
            'instructions.*.description.required' => 'Each instruction must have a description.',
            'instructions.*.description.string' => 'The instruction description must be a string.',
            'category.required' => 'The category field is required.',
            'category.string' => 'The category field must be a string.',
            'category.in' => 'The selected category is invalid.',
        ];
    }

    protected function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY));
        }
    }
}
