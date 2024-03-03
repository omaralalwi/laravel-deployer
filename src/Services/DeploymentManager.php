<?php

namespace Omaralalwi\LaravelDeployer\Services;

use Omaralalwi\LaravelDeployer\Console\Commands\DeployCommand;
use Omaralalwi\LaravelDeployer\Enums\Defaults;
use Omaralalwi\LaravelDeployer\Traits\HasOutput;
use Omaralalwi\LaravelDeployer\Enums\DeploymentCommands;
use Illuminate\Support\Facades\Storage;

class DeploymentManager
{
    use HasOutput;

    private $configReader;
    private $commandExecutor;

    public function __construct(ConfigurationReader $configReader, CommandExecutor $commandExecutor)
    {
        $this->configReader = $configReader;
        $this->commandExecutor = $commandExecutor;
    }

    public function deploy($branch=null): void
    {
        $branch = $branch ?? $this->configReader->getBranch();
        $path = $this->configReader->getPath();

        $this->goToProjectPath($path);
        $this->runBaseCommands($branch);
//      $this->runStoragePermissionCommands($branch); // TODO: fix this error
        $this->runExtraCommands();

        if ($this->configReader->shouldRestartHorizon()) {
            $this->commandExecutor->execute(DeploymentCommands::RESTART_HORIZON);
        }

        if ($this->configReader->shouldRestartPhpFpm()) {
            $this->runPhpFpmCommands();
        }

        if ($this->configReader->shouldBuildNpm()) {
            $this->runNpmCommands();
        }

        $this->runBaseCommands($branch);

        $this->printSuccess("Deployment Process completed successfully!  ^_^  🎉");
    }

    private function goToProjectPath($path): void
    {
        $this->printCommand('Go to project path ..');
        chdir($path);
        $this->printCommand("Current working directory :" . getcwd());
        $this->printCommand('Go to project path ..');
    }

    private function runBaseCommands($branch): void
    {
        $deploymentCommands = DeploymentCommands::getBaseCommands($branch);
        $this->commandExecutor->executeCommands($deploymentCommands);
    }

    private function runCleanCommands(): void
    {
        $cleanCommands = DeploymentCommands::getCleanCommands();
        $this->commandExecutor->executeCommands($cleanCommands);
    }

    private function runStoragePermissionCommands($branch): void
    {
        Storage::disk('public')->setVisibility('storage', 'public');
        Storage::disk('public')->setVisibility('bootstrap/cache', 'public');
    }

    private function runExtraCommands(): void
    {
        $extraCommands = array_merge(DeploymentCommands::getExtraCommands(),$this->configReader->getExtraCommands());
        $this->commandExecutor->executeCommands($extraCommands);
    }

    private function runNpmCommands(): void
    {
        $npmCommands = DeploymentCommands::getNpmCommands();
        $this->commandExecutor->executeCommands($npmCommands);
    }

    private function runPhpFpmCommands(): void
    {
        $sudoUser = $this->configReader->getSudoUser();
        $sudoPassword = $this->configReader->getSudoPassword();
        $restartPhpFpmCommand = $this->configReader->getRestartPhpFpmCommand();
        $this->commandExecutor->executeSudo($sudoUser, $sudoPassword, $restartPhpFpmCommand);
    }

}
