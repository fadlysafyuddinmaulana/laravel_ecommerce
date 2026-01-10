import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        // Admin Plugins
        'resources/css/admin/plugins/select2-custom.css',
        'resources/css/admin/plugins/intl-tel-input-custom.css',
        // Admin Components
        'resources/css/admin/components/filter-buttons.css',
        'resources/css/admin/components/action-buttons.css',
        // Admin Pages
        'resources/css/admin/pages/products.css',
        'resources/css/admin/pages/positions.css',
        'resources/css/admin/pages/employees.css',
        'resources/css/admin/pages/customers.css',
        'resources/css/admin/pages/orders.css',
        'resources/css/admin/pages/departments.css',
        // User Pages
        'resources/css/user/pages/shop.css',
        'resources/css/user/pages/checkout.css',
        'resources/css/user/pages/cart.css',
        'resources/css/user/pages/product-detail.css',
        'resources/css/user/pages/orders.css',
        'resources/css/user/pages/services.css',
        // User Components
        'resources/css/user/components/cart-dropdown.css',
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],
  server: {
    watch: {
      ignored: ['**/storage/framework/views/**'],
    },
  },
});
