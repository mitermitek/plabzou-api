<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    /**
     * Permet de récupérer toutes les catégories
     *
     * @return Collection
     */
    public static function getCategories(): Collection
    {
        return Category::all();
    }

    /**
     * Enregistrer une nouvelle catégorie
     *
     * @param array $data
     * @return Category
     */
    public static function createCategory(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Mettre à jour les informations d'une catégorie
     *
     * @param Category $category
     * @param array $data
     * @return Category
     */
    public static function updateCategory(Category $category, array $data): Category
    {
        $category->update($data);

        return $category;
    }
}
