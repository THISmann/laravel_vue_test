<template>
  <AppLayout>
    <div class="settings-page">
      <h1 class="page-title">Подключить Яндекс</h1>
      <p class="page-hint">
        Укажите ссылку на Яндекс, пример
        https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/
      </p>
      <form @submit.prevent="submit" class="settings-form">
        <div class="form-group">
          <input
            v-model="form.yandex_url"
            type="url"
            class="input-url"
            placeholder="https://yandex.ru/maps/org/..."
          />
          <p v-if="form.errors.yandex_url" class="error">{{ form.errors.yandex_url }}</p>
        </div>
        <button type="submit" class="btn-primary">Сохранить</button>
      </form>
      <p v-if="status === 'saved'" class="success-msg">Настройки сохранены.</p>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  yandexUrl: { type: String, default: '' },
  status: { type: String, default: null },
});

const form = useForm({
  yandex_url: props.yandexUrl,
});

function submit() {
  form.put('/settings');
}
</script>

<style scoped>
.settings-page {
  max-width: 640px;
}

.page-title {
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 0.75rem;
}

.page-hint {
  color: var(--text-muted);
  font-size: 0.95rem;
  margin-bottom: 1.25rem;
  line-height: 1.5;
}

.settings-form .input-url {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid #e5e7eb;
  border-radius: var(--radius-sm);
  margin-bottom: 0.5rem;
}

.settings-form .input-url:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

.settings-form .btn-primary {
  width: auto;
  padding: 0.65rem 1.5rem;
  margin-top: 0.5rem;
}

.success-msg {
  margin-top: 1rem;
  color: #059669;
  font-size: 0.95rem;
}
</style>
