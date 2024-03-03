<?php

namespace Omaralalwi\LaravelDeployer\Enums;

class ConfigKeys
{
    public const BRANCH = 'branch';
    public const PATH = 'path';
    public const EXTRA_COMMANDS = 'extra_commands';
    public const RESTART_HORIZON = 'restart_horizon';
    public const BUILD_NPM = 'build_npm';
    public const RESTART_PHP_FPM = 'restart_php_fpm';
    public const RESTART_PHP_FPM_COMMAND = 'restart_php_fpm_command';
    public const PHP_VERSION = 'php_version';
    public const SUDO_USER = 'sudo_user';
    public const SUDO_PASSWORD = 'sudo_password';
}
