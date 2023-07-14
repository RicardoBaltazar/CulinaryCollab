<?php

namespace Tests\Unit;

use App\Http\Requests\RecipeRequest;
use App\Repositories\RecipeRepository;
use App\Services\RecipeService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\TestCase;

class RecipeTest extends TestCase
{
    public function testGetRecipes()
    {
        $repositoryMock = $this->createMock(RecipeRepository::class);

        $repositoryMock->method('all')
            ->willReturn([
                [
                    'ingredients' => '["ingredient1", "ingredient2"]',
                    'instructions' => '["step1", "step2"]',
                    'created_at' => '2023-07-14 10:00:00',
                    'updated_at' => '2023-07-14 12:00:00'
                ]
            ]);

        $service = new RecipeService($repositoryMock);

        Cache::shouldReceive('remember')
            ->with('recipes', 3600, \Closure::class)
            ->andReturnUsing(function ($key, $minutes, $callback) use ($repositoryMock) {
                $recipes = $callback();
                $repositoryMock->all();
                return $recipes;
            });

        Log::shouldReceive('info')
            ->twice();

        $result = $service->getRecipes();

        $expectedResult = [
            [
                'ingredients' => ['ingredient1', 'ingredient2'],
                'instructions' => ['step1', 'step2']
            ]
        ];
        $this->assertSame($expectedResult, $result);
    }
}
