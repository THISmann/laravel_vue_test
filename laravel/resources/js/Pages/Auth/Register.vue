<template>
  <div class="auth-page">
    <div class="auth-card">
      <h1>Регистрация</h1>
      <div v-if="hasErrors" class="error-summary" role="alert">
        <strong>Veuillez corriger les erreurs ci-dessous.</strong>
      </div>
      <form @submit.prevent="submit" novalidate>
        <div class="form-group">
          <label for="name">Имя</label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            required
            autofocus
            autocomplete="name"
            :aria-invalid="!!errorText('name')"
            :aria-describedby="errorText('name') ? 'name-error' : undefined"
          />
          <p v-if="errorText('name')" id="name-error" class="error">{{ errorText('name') }}</p>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
            autocomplete="username"
            :aria-invalid="!!errorText('email')"
            :aria-describedby="errorText('email') ? 'email-error' : undefined"
          />
          <p v-if="errorText('email')" id="email-error" class="error">{{ errorText('email') }}</p>
        </div>
        <div class="form-group">
          <label for="password">Пароль</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            required
            autocomplete="new-password"
            :aria-invalid="!!errorText('password')"
            :aria-describedby="errorText('password') ? 'password-error' : undefined"
          />
          <p v-if="errorText('password')" id="password-error" class="error">{{ errorText('password') }}</p>
        </div>
        <div class="form-group">
          <label for="password_confirmation">Подтверждение пароля</label>
          <input
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            required
            autocomplete="new-password"
            :aria-invalid="!!errorText('password_confirmation')"
            :aria-describedby="errorText('password_confirmation') ? 'password_confirmation-error' : undefined"
          />
          <p v-if="errorText('password_confirmation')" id="password_confirmation-error" class="error">{{ errorText('password_confirmation') }}</p>
        </div>
        <button type="submit" class="btn-primary" :disabled="form.processing">
          {{ form.processing ? 'Chargement...' : 'Зарегистрироваться' }}
        </button>
      </form>
      <p class="auth-links">
        Уже есть аккаунт? <Link href="/login">Вход</Link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const hasErrors = computed(() => form.errors && Object.keys(form.errors).length > 0);

function errorText(field) {
  const e = form.errors[field];
  if (e == null) return '';
  return Array.isArray(e) ? e.join(' ') : String(e);
}

function submit() {
  form.post('/register', {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
}
</script>
