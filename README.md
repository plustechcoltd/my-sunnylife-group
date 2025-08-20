# Introduction

## Environment Setup

Follow these steps

1. Install [Workspace](https://github.com/my127/workspace), Docker
2. Copy `.githooks` folder to `.git/hooks` folder
   ```
   cp -r .githooks/* .git/hooks
   chmod +x .git/hooks/pre-push
   ```
3. Define your own environment variables: `cp .env.example .env`
   Edit `DEV_NAME` to current user name
4. Build the project: `ws setup`
5. After the setup is done, start the console: `ws console` and run the following 1 time use commands:
   - `php artisan key:generate`
   - `php artisan storage:link`
   - `php artisan db:seed`

Congratulation! Now your local environment `http://localhost:8800` is ready for development.

## Notifications and Chat Setup
1. Create a new Pusher account
2. Enable client events in App settings of Pusher
3. Update `.env` file with your Pusher credentials`
```
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=
```

## Development Guide
1. Always run `ws setup` after pulling new changes
2. Always run `ws console` and run the following commands after pulling new changes:
   - `php artisan migrate`
   - `php artisan db:seed --class=xxxSeeder` (if there are new seeders)
3. After making changes to JS or CSS, run `ws fe build` to compile assets

## Mysql Connection
There is 2 ways to connect to the database:
1. Using PHPMyAdmin: [localhost:8807](http://localhost:8807)
   - Username: username
   - Password: password
   - Database: laravel
2. Using MySQL Workbench: Open new connection with the following details:
   - Host: 127.0.0.1
   - Port: 3308
   - Username: username
   - Password: password
   - Database: laravel

## Useful Commands
- `ws`: list all useful commands
- `ws setup`: setup environment for the first time
- `ws start`: start docker containers
- `ws stop`: stop docker containers
- `ws restart`: restart all containers
- `ws console`: enter php-fpm container

## Useful links:
1. PHPMyAdmin: [localhost:8807](http://localhost:8836)
2. Mailhog: [localhost:8805](http://localhost:8835)
