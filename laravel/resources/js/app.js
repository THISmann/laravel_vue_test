import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp, router } from '@inertiajs/vue3';

// --- CSRF: keep token in sync and send it on every request (avoids 419 Page Expired) ---
function getCsrfToken() {
  const el = document.querySelector('meta[name="csrf-token"]');
  return el ? el.getAttribute('content') : null;
}

function setCsrfToken(token) {
  if (!token) return;
  let el = document.querySelector('meta[name="csrf-token"]');
  if (!el) {
    el = document.createElement('meta');
    el.setAttribute('name', 'csrf-token');
    document.head.appendChild(el);
  }
  el.setAttribute('content', token);
  if (typeof window !== 'undefined' && window.axios) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
  }
}

// After every Inertia response, refresh the meta tag so it always matches the session.
router.on('finish', () => {
  const page = router.page;
  const token = page?.props?.csrf_token;
  if (token) setCsrfToken(token);
});

// Backup: also inject token in inertia:before (in case visitOptions runs on a clone).
document.addEventListener('inertia:before', (event) => {
  const visit = event.detail.visit;
  const token = getCsrfToken();
  if (!token) return;
  visit.headers = { ...visit.headers, 'X-CSRF-TOKEN': token };
  const method = (visit.method || 'get').toLowerCase();
  if (method !== 'get' && method !== 'head' && visit.data && typeof visit.data === 'object' && !(visit.data instanceof FormData)) {
    visit.data = { ...visit.data, _token: token };
  }
});

const appName = import.meta.env.VITE_APP_NAME || 'Daily Grow';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    // Inject CSRF token into every visit (before request is built) so Laravel never gets 419.
    defaults: {
      visitOptions: (href, options) => {
        const token = getCsrfToken();
        if (token) {
          options.headers = { ...options.headers, 'X-CSRF-TOKEN': token };
          const method = (options.method || 'get').toLowerCase();
          if (method !== 'get' && method !== 'head') {
            options.data = { ...(options.data || {}), _token: token };
          }
        }
        return options;
      },
    },
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue');
        const path = `./Pages/${name}.vue`;
        let fn = pages[path];
        if (!fn) {
            const lastSlash = path.lastIndexOf('/');
            const lowerPath = lastSlash >= 0
                ? path.slice(0, lastSlash + 1) + path.slice(lastSlash + 1).toLowerCase()
                : path.toLowerCase();
            fn = pages[lowerPath];
        }
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
