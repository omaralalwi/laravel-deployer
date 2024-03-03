<?php

namespace Omaralalwi\LaravelDeployer\Services;

use Illuminate\Support\Facades\Config;
use Omaralalwi\LaravelDeployer\Enums\Defaults;

class ConfigurationReader
{
    public function getBranch(): string
    {
        return Config::get('laravel-deployer.branch', Defaults::BRANCH);
    }

    public function getPath(): string
    {
        return Config::get('laravel-deployer.path', getcwd());
    }

    public function getExtraCommands(): array
    {
        return Config::get('laravel-deployer.extra_commands', []);
    }

    public function shouldRestartPhpFpm(): bool
    {
        return Config::get('laravel-deployer.restart_php_fpm', false);
    }

    public function shouldRestartHorizon(): bool
    {
        return Config::get('laravel-deployer.restart_horizon', false);
    }

    public function shouldBuildNpm(): bool
    {
        return Config::get('laravel-deployer.build_npm', false);
    }

    public function getSudoUser(): string
    {
        return Config::get('laravel-deployer.sudo_user');
    }

    public function getSudoPassword(): string
    {
        return Config::get('laravel-deployer.sudo_password');
    }

    public function getRestartPhpFpmCommand(): string
    {
        return Config::get('laravel-deployer.restart_php_fpm_command');
    }
}
