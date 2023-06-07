import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/project.ts',
        'resources/js/projects-list.ts'
      ],
      refresh: true,
    }),
  ],
});
