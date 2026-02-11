<template>
  <div class="app-layout">
    <aside class="sidebar">
      <div class="logo">
        <span class="logo-icon">➤</span>
        <span class="logo-text">Daily Grow</span>
      </div>
      <p class="account-name">Название аккаунта</p>
      <nav class="nav">
        <Link
          href="/reviews"
          class="nav-item"
          :class="{ active: url.startsWith('/reviews') }"
        >
          <span class="nav-icon">★</span>
          Отзывы
        </Link>
        <Link
          href="/settings"
          class="nav-item"
          :class="{ active: url.startsWith('/settings') }"
        >
          Настройка
        </Link>
      </nav>
    </aside>
    <div class="main-wrap">
      <header class="header">
        <div class="header-spacer"></div>
        <button
          type="button"
          class="logout-btn"
          @click="logout"
        >
          <span class="arrow-icon">→</span>
        </button>
      </header>
      <main class="main">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const url = computed(() => page.url);

function logout() {
  router.post('/logout');
}
</script>

<style scoped>
.app-layout {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: 240px;
  min-width: 240px;
  background: var(--sidebar-bg);
  padding: 1.5rem 0;
  border-right: 1px solid #eee;
}

.logo {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0 1.25rem 1.25rem;
  border-bottom: 1px solid #eee;
  margin-bottom: 1rem;
}

.logo-icon {
  font-size: 1.25rem;
  color: var(--primary);
}

.logo-text {
  font-weight: 700;
  font-size: 1.1rem;
}

.account-name {
  font-size: 0.85rem;
  color: var(--text-muted);
  padding: 0 1.25rem;
  margin-bottom: 1rem;
}

.nav {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
  padding: 0 0.75rem;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.65rem 0.75rem;
  border-radius: var(--radius-sm);
  color: var(--text);
  text-decoration: none;
  font-size: 0.95rem;
  transition: background 0.15s;
}

.nav-item:hover {
  background: var(--sidebar-active);
  text-decoration: none;
}

.nav-item.active {
  background: var(--sidebar-active);
  font-weight: 500;
}

.nav-icon {
  font-size: 1rem;
  color: var(--star);
}

.main-wrap {
  flex: 1;
  display: flex;
  flex-direction: column;
  min-width: 0;
}

.header {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding: 1rem 1.5rem;
  border-bottom: 1px solid #eee;
  background: white;
}

.logout-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border: 1px solid #e5e7eb;
  border-radius: var(--radius-sm);
  background: white;
  color: var(--text-muted);
  font-size: 1.25rem;
  transition: background 0.15s, color 0.15s;
}

.logout-btn:hover {
  background: var(--sidebar-bg);
  color: var(--text);
  text-decoration: none;
}

.arrow-icon {
  line-height: 1;
}

.main {
  flex: 1;
  padding: 1.5rem;
  background: var(--main-bg);
  overflow: auto;
}
</style>
