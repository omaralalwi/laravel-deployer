<?php

use Omaralalwi\LaravelDeployer\Enums\{Defaults, ConfigKeys};

/**
 * Laravel Deployer Configuration File
 *
 * This file contains configuration options for the Laravel Deployer package.
 * Adjust these settings to customize the deployment process for your Laravel application.
 *
 * @see https://github.com/omaralalwi/laravel-deployer
 */

return [
    /**
     * Git branch to be deployed.
     *
     * @var string
     */
    ConfigKeys::BRANCH => env('DEPLOY_BRANCH', Defaults::BRANCH),

    /**
     * Path to the Laravel project on the server.
     *
     * @var string
     */
    ConfigKeys::PATH => env('DEPLOY_PATH'),

    /**
     * Extra commands to be executed during deployment.
     *
     * @var array
     */
    ConfigKeys::EXTRA_COMMANDS => [],

    /**
     * Whether to restart Horizon after deployment.
     *
     * @var bool
     */
    ConfigKeys::RESTART_HORIZON => env('DEPLOY_RESTART_HORIZON', Defaults::RESTART_HORIZON),

    /**
     * Whether to build NPM assets during deployment.
     *
     * @var bool
     */
    ConfigKeys::BUILD_NPM => env('DEPLOY_BUILD_NPM', Defaults::BUILD_NPM),

    /**
     * Whether to restart PHP-FPM after deployment.
     *
     * @var bool
     */
    ConfigKeys::RESTART_PHP_FPM => env('DEPLOY_RESTART_PHP_FPM', Defaults::RESTART_PHP_FPM),

    /**
     * Command to restart PHP-FPM (if applicable).
     *
     * @var string|null
     */
    ConfigKeys::RESTART_PHP_FPM_COMMAND => env('DEPLOY_RESTART_PHP_FPM_COMMAND'),

    /**
     * PHP version to use during deployment.
     *
     * @var string|null
     */
    ConfigKeys::PHP_VERSION => env('DEPLOY_PHP_VERSION'),

    /**
     * User for sudo commands (if applicable).
     *
     * @var string|null
     */
    ConfigKeys::SUDO_USER => env('DEPLOY_SUDO_USER'),

    /**
     * Password for the sudo user (if applicable).
     *
     * @var string|null
     */
    ConfigKeys::SUDO_PASSWORD => env('DEPLOY_SUDO_USER_PASSWORD'),
];
