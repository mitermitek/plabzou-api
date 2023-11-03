<?php

namespace App\Http\Controllers\API\Promotion;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Promotion\PromotionRequest;
use App\Models\Promotion;
use App\Services\Promotion\PromotionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PromotionController extends BaseController
{
    public function index(Request $request): JsonResponse
    {
        $promotions = PromotionService::getPromotions($request->all());

        return $this->success($promotions->toArray(), 'Promotions récupérées avec succès.');
    }

    /**
     * @throws Exception
     */
    public function store(PromotionRequest $request): JsonResponse
    {
        $promotion = PromotionService::createPromotion($request->validated());

        return $this->success($promotion->toArray(), 'Promotion créée avec succès.');
    }

    public function show(Promotion $promotion, Request $request ): JsonResponse
    {
        $promotion->load('course', 'learners', 'city', 'course');

        if ($request->advancement) {
            $promotion->load('timeslots.training', 'timeslots.teachers', 'timeslots.room', 'timeslots.learners', 'timeslots.promotions');
            PromotionService::calculatePromotionAdvancement($promotion);
        }

        return $this->success($promotion->toArray(), 'Promotion récupérée avec succès.');
    }

    public function update(PromotionRequest $request, Promotion $promotion): JsonResponse
    {
        $promotion = PromotionService::updatePromotion($promotion, $request->validated());

        return $this->success($promotion->toArray(), 'Promotion mise à jour avec succès.');
    }

    public function destroy(Promotion $promotion): JsonResponse
    {
        $promotion->load('learners');
        PromotionService::deletePromotion($promotion);

        return $this->success([], 'Promotion supprimée avec succès.');
    }
}
