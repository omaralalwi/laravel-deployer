<?php

namespace Omaralalwi\LaravelDeployer\Traits;

use Omaralalwi\LaravelDeployer\Enums\Styles;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

trait HasOutput
{
    public function printCommand(string $command): void
    {
        $commandStyle = Styles::BOLD . Styles::GREEN;
        echo $commandStyle . "Running command: " . Styles::RESET . PHP_EOL;
        echo $commandStyle . $command . Styles::RESET . PHP_EOL;
    }

    public function printError(Process $process): void
    {
        $errorStyle = Styles::BOLD . Styles::RED;
        echo $errorStyle . "Command failed: " . Styles::RESET . PHP_EOL;
        echo $errorStyle . $process->getErrorOutput() . Styles::RESET . PHP_EOL;
        throw new ProcessFailedException($process);
    }

    public function printSuccess($msg): void
    {
        $errorStyle = Styles::BOLD . Styles::GREEN;
        echo $errorStyle . $msg. Styles::RESET . PHP_EOL;
    }

    public function printCommandOutput(string $output): void
    {
        $outputStyle = Styles::BOLD . Styles::GREEN;
        echo $outputStyle . "Command output: " . Styles::RESET . PHP_EOL;
        echo $outputStyle . $output . Styles::RESET . PHP_EOL;
    }

    public function outputPublicKey($keyPath)
    {
        // Wait for a short moment to ensure the file is created
        usleep(50000); // 50 milliseconds

        if (file_exists($keyPath)) {
            $keyContent = file_get_contents($keyPath);
            $this->output->writeln("");
            $this->output->writeln("<fg=yellow;options=bold>** ------------------------------- SSH Key ------------------------------- **</>");
            $this->output->writeln("");
            $this->info("$keyContent");
            $this->output->writeln("");
            $this->output->writeln("<fg=yellow;options=bold>** ---------------------------------------------------------------------------------- **</>");
            $this->output->writeln("");
            $this->output->writeln(" |  Copy and paste this key to your GitHub account:");
            $this->output->writeln(" |  For more instructions, see:");
            $this->output->writeln("<fg=yellow;options=bold> https://omaralalwi.github.io/laravel-deployer/#/?id=setup-github-SSH-connection </>");
            $this->output->writeln("");
        } else {
            $this->error('<fg=red;options=bold> public key not found </>');
        }
        exit();
    }

}
