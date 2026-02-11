<template>
  <div class="auth-page">
    <div class="auth-card">
      <h1>Вход</h1>
      <p v-if="flash?.error" class="error flash-error">{{ flash.error }}</p>
      <form @submit.prevent="submit">
        <div class="form-group">
          <label for="email">Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
            autofocus
            autocomplete="username"
          />
          <p v-if="form.errors.email" class="error">{{ form.errors.email }}</p>
        </div>
        <div class="form-group">
          <label for="password">Пароль</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            required
            autocomplete="current-password"
          />
          <p v-if="form.errors.password" class="error">{{ form.errors.password }}</p>
        </div>
        <button type="submit" class="btn-primary">Войти</button>
      </form>
      <p class="auth-links">
        Нет аккаунта? <Link href="/register">Регистрация</Link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';

const flash = usePage().props.flash;
const form = useForm({
  email: '',
  password: '',
  remember: false,
});

function submit() {
  form.post('/login', {
    onFinish: () => form.reset('password'),
  });
}
</script>
