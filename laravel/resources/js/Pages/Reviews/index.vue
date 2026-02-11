<template>
  <AppLayout>
    <div class="reviews-page">
      <div class="reviews-header">
        <div class="header-left">
          <a
            v-if="yandexUrl"
            :href="yandexUrl"
            target="_blank"
            rel="noopener"
            class="yandex-link"
          >
            <span class="pin-icon">📍</span>
            {{ linkLabel }}
          </a>
          <span v-else class="no-link">Яндекс Карты</span>
        </div>
        <div v-if="rating !== null" class="rating-block">
          <span class="rating-value">{{ rating }}</span>
          <span class="stars">
            <template v-for="i in 5" :key="i">
              <span
                class="star"
                :class="{ filled: i <= Math.floor(rating), half: i === Math.ceil(rating) && rating % 1 !== 0 }"
              >★</span>
            </template>
          </span>
          <p class="total-reviews">Всего отзывов: {{ totalReviews.toLocaleString('ru-RU') }}</p>
        </div>
      </div>

      <p v-if="!yandexUrl" class="empty-hint">
        Укажите ссылку на карточку организации в
        <Link href="/settings">настройках</Link>, чтобы загрузить отзывы.
      </p>

      <div v-else class="review-cards">
        <article
          v-for="(review, index) in reviews"
          :key="index"
          class="review-card"
        >
          <div class="review-meta">
            <span class="review-date">{{ review.date }}</span>
            <span class="review-branch">
              <span class="pin-icon small">📍</span>
              {{ review.branch }}
            </span>
          </div>
          <p class="review-author">{{ review.author_name }} {{ review.author_phone }}</p>
          <div class="review-stars">
            <template v-for="i in 5" :key="i">
              <span class="star filled">★</span>
            </template>
          </div>
          <p class="review-text">{{ review.text }}</p>
        </article>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
  yandexUrl: { type: String, default: null },
  linkLabel: { type: String, default: 'Яндекс Карты' },
  rating: { type: Number, default: null },
  totalReviews: { type: Number, default: 0 },
  reviews: { type: Array, default: () => [] },
});
</script>

<style scoped>
.reviews-page {
  max-width: 800px;
}

.reviews-header {
  display: flex;
  flex-wrap: wrap;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.header-left {
  flex: 1;
  min-width: 0;
}

.yandex-link {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  color: var(--text);
  font-weight: 500;
  text-decoration: none;
}

.yandex-link:hover {
  color: var(--primary);
  text-decoration: none;
}

.no-link {
  color: var(--text-muted);
}

.pin-icon {
  color: var(--pin);
  font-size: 1rem;
}

.pin-icon.small {
  font-size: 0.85rem;
}

.rating-block {
  background: #f9fafb;
  border: 1px solid #eee;
  border-radius: var(--radius);
  padding: 1rem 1.25rem;
  min-width: 180px;
}

.rating-value {
  font-size: 1.75rem;
  font-weight: 700;
  margin-right: 0.5rem;
}

.stars {
  display: inline-flex;
  gap: 0.1rem;
}

.star {
  color: #d1d5db;
  font-size: 1.25rem;
}

.star.filled {
  color: var(--star);
}

.star.half {
  color: var(--star);
  opacity: 0.6;
}

.total-reviews {
  margin-top: 0.5rem;
  font-size: 0.9rem;
  color: var(--text-muted);
}

.empty-hint {
  color: var(--text-muted);
  padding: 2rem;
  background: #f9fafb;
  border-radius: var(--radius);
}

.review-cards {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.review-card {
  background: white;
  border: 1px solid #eee;
  border-radius: var(--radius);
  padding: 1.25rem;
  box-shadow: var(--shadow);
}

.review-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;
  margin-bottom: 0.5rem;
  font-size: 0.9rem;
  color: var(--text-muted);
}

.review-branch {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
}

.review-author {
  font-size: 0.95rem;
  font-weight: 500;
  margin-bottom: 0.35rem;
}

.review-stars {
  margin-bottom: 0.5rem;
}

.review-stars .star {
  font-size: 1rem;
}

.review-text {
  font-size: 0.95rem;
  line-height: 1.6;
  color: var(--text);
}
</style>
