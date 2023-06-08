import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/projects-list.css',
        'resources/css/project-page.css',
      ],
      refresh: true,
    }),
  ],
});
