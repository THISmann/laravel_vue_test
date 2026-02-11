import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';

// Ensure every Inertia request includes the CSRF token (fixes 419 on login/form submit)
const csrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
document.addEventListener('inertia:before', (event) => {
  const token = csrfToken();
  if (token) {
    event.detail.visit.headers = {
      ...event.detail.visit.headers,
      'X-CSRF-TOKEN': token,
      'Accept': 'application/json',
    };
  }
});

const appName = import.meta.env.VITE_APP_NAME || 'Daily Grow';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue');
        const path = `./Pages/${name}.vue`;
        const fn = pages[path];
        if (!fn) throw new Error(`Page not found: ${path}`);
        return fn();
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
    progress: {
        color: '#2563eb',
        showSpinner: true,
    },
});
