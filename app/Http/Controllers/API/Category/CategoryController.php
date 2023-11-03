<?php

namespace App\Http\Controllers\API\Category;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Category\CategoryRequest;
use App\Models\Category;
use App\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends BaseController
{
    public function index(): JsonResponse
    {
        $categories = CategoryService::getCategories();

        return $this->success($categories->toArray(), 'Catégories récupérées avec succès.');
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        $category = CategoryService::createCategory($request->validated());

        return $this->success($category->toArray(), 'Catégorie créée avec succès.');
    }

    public function show(Category $category): JsonResponse
    {
        return $this->success($category->toArray(), 'Catégorie récupérée avec succès.');
    }

    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $category = CategoryService::updateCategory($category, $request->validated());

        return $this->success($category->toArray(), 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return $this->success([], 'Catégorie supprimée avec succès.');
    }
}
