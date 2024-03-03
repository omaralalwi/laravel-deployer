<?php

namespace Omaralalwi\LaravelDeployer\Enums;

class DeploymentCommands
{
    public const GIT_FETCH = 'git fetch origin $branch';
    public const COMPOSER_INSTALL = 'composer install --no-interaction --prefer-dist --optimize-autoloader';
    public const ARTISAN_MIGRATE = 'php artisan migrate --force';
    public const ARTISAN_KEY_GENERATE = 'php artisan key:generate';
    public const RESTART_HORIZON = 'php artisan horizon:terminate';
    public const NPM_INSTALL = 'npm install';
    public const NPM_RUN_DEV = 'npm run dev';
    public const NPM_RUN_BUILD = 'npm run build';

    public const CACHE_CLEAR = 'php artisan cache:clear';
    public const ROUTE_CLEAR = 'php artisan route:clear';
    public const CONFIG_CLEAR = 'php artisan config:clear';
    public const VIEW_CLEAR = 'php artisan view:clear';
    public const CONFIG_CACHE = 'php artisan config:cache';
    public const ROUTE_CACHE = 'php artisan route:cache';
    public const VIEW_CACHE = 'php artisan view:cache';

    public static function getBaseCommands(string $branch): array
    {
        return [
            str_replace('$branch', $branch, self::GIT_FETCH),
            self::COMPOSER_INSTALL,
            self::ARTISAN_MIGRATE,
            self::ARTISAN_KEY_GENERATE,
        ];
    }

    public static function getExtraCommands(): array
    {
        return [];
    }

    public static function getNpmCommands(): array
    {
        if (env('APP_ENV') === 'production') {
            return [
                self::NPM_INSTALL,
                self::NPM_RUN_BUILD,
            ];
        }

        return [
            self::NPM_INSTALL,
            self::NPM_RUN_DEV,
        ];
    }

    public static function getCleanCommands(): array
    {
        return [
            self::CACHE_CLEAR,
            self::ROUTE_CLEAR,
            self::CONFIG_CLEAR,
            self::VIEW_CLEAR,
            self::CONFIG_CACHE,
            self::ROUTE_CACHE,
            self::VIEW_CACHE,
        ];
    }


}
