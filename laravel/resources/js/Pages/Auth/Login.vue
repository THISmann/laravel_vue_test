<template>
  <div class="auth-page">
    <div class="auth-card">
      <h1>Вход</h1>
      <p v-if="flash?.error" class="error flash-error">{{ flash.error }}</p>
      <div v-if="hasErrors" class="error-summary" role="alert">
        <strong>Veuillez corriger les erreurs ci-dessous.</strong>
      </div>
      <form @submit.prevent="submit" novalidate>
        <div class="form-group">
          <label for="email">Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
            autofocus
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
            autocomplete="current-password"
            :aria-invalid="!!errorText('password')"
            :aria-describedby="errorText('password') ? 'password-error' : undefined"
          />
          <p v-if="errorText('password')" id="password-error" class="error">{{ errorText('password') }}</p>
        </div>
        <button type="submit" class="btn-primary" :disabled="form.processing">
          {{ form.processing ? 'Chargement...' : 'Войти' }}
        </button>
      </form>
      <p class="auth-links">
        Нет аккаунта? <Link href="/register">Регистрация</Link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const flash = usePage().props.flash;
const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const hasErrors = computed(() => form.errors && Object.keys(form.errors).length > 0);

function errorText(field) {
  const e = form.errors[field];
  if (e == null) return '';
  return Array.isArray(e) ? e.join(' ') : String(e);
}

function submit() {
  form.post('/login', {
    onFinish: () => form.reset('password'),
  });
}
</script>
