<template>
  <AppLayout>
    <div class="profile-page">
      <h1 class="page-title">Профиль</h1>
      <form @submit.prevent="submit" class="settings-form">
        <div class="form-group">
          <label>Имя</label>
          <input v-model="form.name" type="text" required />
          <p v-if="form.errors.name" class="error">{{ form.errors.name }}</p>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input v-model="form.email" type="email" required />
          <p v-if="form.errors.email" class="error">{{ form.errors.email }}</p>
        </div>
        <button type="submit" class="btn-primary">Сохранить</button>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';

defineProps({
  mustVerifyEmail: Boolean,
  status: String,
});

const page = usePage();
const authUser = page.props.auth?.user ?? {};
const form = useForm({
  name: authUser.name ?? '',
  email: authUser.email ?? '',
});

function submit() {
  form.patch('/profile');
}
</script>

<style scoped>
.profile-page { max-width: 480px; }
.page-title { font-size: 1.5rem; margin-bottom: 1rem; }
</style>
