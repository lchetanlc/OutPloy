# Uptime Monitor

Overview

Laravel + Vue app that monitors client websites every 15 minutes and emails clients when a site goes down.

How to run (local)

Prereqs: PHP, Composer, Node/npm, MySQL/MariaDB, Redis

Commands:

cp .env.example .env    # update DB, QUEUE_CONNECTION, MAIL_*
composer install
php artisan key:generate
php artisan migrate --seed
npm install && npm run dev
php artisan queue:work
php artisan schedule:work
php artisan serve

Quick test:

php artisan monitor:dispatch-checks
php artisan queue:work --once
tail -n 200 storage/logs/laravel.log

That's it — core monitoring lives in app/Jobs/CheckWebsiteJob.php and email logic is in app/Mail/.
