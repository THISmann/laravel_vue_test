<?php

namespace App\Services;

/**
 * Сервис для получения отзывов и рейтинга из карточки организации Яндекс.Карт.
 *
 * Примечание: Яндекс не предоставляет публичное API для отзывов. В продакшене
 * можно использовать: 1) Yandex Business API (платный), 2) парсинг страницы
 * (с учётом правил использования). Здесь возвращаются демо-данные по формату макета.
 */
class YandexReviewsService
{
    private const EXAMPLE_RATING = 4.7;
    private const EXAMPLE_TOTAL = 1145;
    private const EXAMPLE_LINK_LABEL = 'Яндекс Карты';

    /**
     * Извлечь ID организации из URL вида:
     * https://yandex.ru/maps/org/slug/123456789/reviews/
     */
    public function parseOrgIdFromUrl(string $url): ?string
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }
        $path = parse_url($url, PHP_URL_PATH);
        if (! $path) {
            return null;
        }
        // .../org/slug/ID/reviews/ или .../org/ID/reviews/
        if (preg_match('#/org/[^/]+/(\d+)(?:/reviews)?#', $path, $m)) {
            return $m[1];
        }
        if (preg_match('#/org/(\d+)(?:/reviews)?#', $path, $m)) {
            return $m[1];
        }
        return null;
    }

    /**
     * Получить рейтинг, общее количество отзывов и список отзывов.
     * Для демо возвращаются данные в формате макета.
     */
    public function getReviewsAndRating(string $yandexUrl): array
    {
        $orgId = $this->parseOrgIdFromUrl($yandexUrl);

        // Демо-данные по макету (реальное API/парсинг подключается отдельно)
        $rating = self::EXAMPLE_RATING;
        $totalReviews = self::EXAMPLE_TOTAL;
        $linkLabel = self::EXAMPLE_LINK_LABEL;
        $reviews = $this->getDemoReviews();

        // Здесь можно по orgId вызывать внешний API или парсер
        // if ($orgId) { ... }

        return [
            'rating' => $rating,
            'total_reviews' => $totalReviews,
            'link_label' => $linkLabel,
            'reviews' => $reviews,
        ];
    }

    private function getDemoReviews(): array
    {
        $text = 'Разнообразные алкогольные напитки, много закусок и обычных блюд. Кухня вкусная, разнообразная — от супов и салатов до мясных изделий. Персонал — молодые девушки, коммуникабельные и доброжелательные, всегда подскажут, принесут вовремя и вызовут такси. Летняя веранда — свежо и тепло, в жару в самый раз. Залы не осматривали подробно, но видно, что удобные и просторные.';

        return [
            [
                'date' => '12.09.2022 14:22',
                'branch' => 'Филиал 1',
                'author_name' => 'Наталья',
                'author_phone' => '+7 900 540 40 40',
                'rating' => 5,
                'text' => $text,
            ],
            [
                'date' => '11.09.2022 10:15',
                'branch' => 'Филиал 1',
                'author_name' => 'Алексей',
                'author_phone' => '+7 916 123 45 67',
                'rating' => 5,
                'text' => $text,
            ],
            [
                'date' => '10.09.2022 18:44',
                'branch' => 'Филиал 1',
                'author_name' => 'Мария',
                'author_phone' => '+7 903 987 65 43',
                'rating' => 5,
                'text' => $text,
            ],
        ];
    }
}
