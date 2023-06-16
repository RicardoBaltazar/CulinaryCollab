<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $table = "recipes";

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'ingredients',
        'instructions',
        'category',
    ];

    public function scopeGetUserRecipes($query, int $user_id)
    {
        return $query->select()->where('user_id', '=', $user_id)->get();
    }

    public function scopeSearchRecipe($query, string $attributes)
    {
        return $query->select()->where('title', 'like', '%' . $attributes . '%')->get();
    }

    public function users()
    {
        return $this->hasOne(User::class);
    }
}
