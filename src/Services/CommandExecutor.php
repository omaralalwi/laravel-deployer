<?php

namespace Omaralalwi\LaravelDeployer\Services;

use Symfony\Component\Process\Process;
use Omaralalwi\LaravelDeployer\Enums\Styles;
use Omaralalwi\LaravelDeployer\Traits\HasOutput;

class CommandExecutor
{
    use HasOutput;

    public function execute(string $command): void
    {
        $this->printCommand($command);

        $process = Process::fromShellCommandline($command);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->printError($process);
        } else {
            $this->printCommandOutput($process->getOutput());
        }
    }

    public function executeCommands(array $commands): void
    {
        foreach ($commands as $command) {
            $this->execute($command);
        }
    }

    public function executeSudo(string $user, string $password, string $command): void
    {
        $command = "echo '$password' | sudo -S $command";
        $this->execute($command);
    }

}
