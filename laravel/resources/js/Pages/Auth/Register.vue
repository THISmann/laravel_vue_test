<template>
  <div class="auth-page">
    <div class="auth-card">
      <h1>Регистрация</h1>
      <form @submit.prevent="submit">
        <div class="form-group">
          <label for="name">Имя</label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            required
            autofocus
            autocomplete="name"
          />
          <p v-if="form.errors.name" class="error">{{ form.errors.name }}</p>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
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
            autocomplete="new-password"
          />
          <p v-if="form.errors.password" class="error">{{ form.errors.password }}</p>
        </div>
        <div class="form-group">
          <label for="password_confirmation">Подтверждение пароля</label>
          <input
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            required
            autocomplete="new-password"
          />
        </div>
        <button type="submit" class="btn-primary">Зарегистрироваться</button>
      </form>
      <p class="auth-links">
        Уже есть аккаунт? <Link href="/login">Вход</Link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

function submit() {
  form.post('/register', {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
}
</script>
