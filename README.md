# Uptime Monitor

Overview

Small Laravel + Vue app that checks client websites every 15 minutes and emails clients when a site is down.

How to run (local)

Prereqs: PHP, Composer, Node/npm, MySQL/MariaDB, Redis.

Copy .env.example to .env and update DB, queue, and mail settings.

Install backend deps, generate app key, and run migrations.

Install frontend deps and build assets.

Run the queue worker, scheduler, and local server.

Commands

cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
npm install && npm run dev
php artisan queue:work
php artisan schedule:work
php artisan serve


Quick test

Manually dispatch checks, process a single job, and check the logs.

php artisan monitor:dispatch-checks
php artisan queue:work --once
tail -n 200 storage/logs/laravel.log


That’s it — core monitoring is in app/Jobs/CheckWebsiteJob.php, mailables in app/Mail/.
