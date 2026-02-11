<?php

namespace App\Http\Controllers;

use App\Services\YandexReviewsService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReviewController extends Controller
{
    public function __construct(
        private YandexReviewsService $yandexReviews
    ) {}

    public function index(Request $request): Response
    {
        $user = $request->user();
        $yandexUrl = $user->yandex_url;
        $rating = null;
        $totalReviews = 0;
        $reviews = [];
        $linkLabel = null;

        if ($yandexUrl) {
            $data = $this->yandexReviews->getReviewsAndRating($yandexUrl);
            $rating = $data['rating'];
            $totalReviews = $data['total_reviews'];
            $reviews = $data['reviews'];
            $linkLabel = $data['link_label'] ?? 'Яндекс Карты';
        }

        return Inertia::render('Reviews/Index', [
            'yandexUrl' => $yandexUrl,
            'linkLabel' => $linkLabel,
            'rating' => $rating,
            'totalReviews' => $totalReviews,
            'reviews' => $reviews,
        ]);
    }
}
