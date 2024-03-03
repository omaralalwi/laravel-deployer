<?php

namespace Omaralalwi\LaravelDeployer\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Omaralalwi\LaravelDeployer\Traits\HasOutput;
use Omaralalwi\LaravelDeployer\Enums\{Defaults, SSHKeyOptions};

class GenerateSshKey extends Command
{
    use HasOutput;

    protected $signature = 'deploy:key-generate {email}';
    protected $description = 'Generate or display an SSH key pair';

    public function handle()
    {
        $email = $this->argument('email');
        $publicKeyPath = $_SERVER['HOME'] . '/.ssh/'.Defaults::SSH_KEY_NAME.'.pub';

        if ($this->keyExists($publicKeyPath)) {
            $this->askUserForAction($email);
        } else {
            $this->info("No existing SSH key pair found. Generating new key pair for email: $email ...");
            $this->generateKeyPair($email);
        }
    }

    protected function askUserForAction($email)
    {
        $action = $this->choice('What would you like to do?', [SSHKeyOptions::SHOW_CURRENT_KEY, SSHKeyOptions::CREATE_NEW_KEY], 0);

        switch ($action) {
            case SSHKeyOptions::SHOW_CURRENT_KEY:
                $publicKeyPath = $_SERVER['HOME'] . '/.ssh/'.Defaults::SSH_KEY_NAME.'.pub';
                $this->outputPublicKey($publicKeyPath);
                break;
            case SSHKeyOptions::CREATE_NEW_KEY:
                $this->info("Generating a new SSH key pair for email: $email ...");
                $this->generateKeyPair($email);
                break;
        }
    }

    protected function generateKeyPair($email)
    {
        $defaultKeyName = Defaults::SSH_KEY_NAME;
        $keyName = $this->askForKeyName($defaultKeyName);
        $privateKeyPath = $this->getPrivateKeyPath($keyName);
        $publicKeyPath = $this->getPublicKeyPath($privateKeyPath);

        if ($this->keyExists($publicKeyPath)) {
            $this->info("Please insert another name for the key.");
            $keyName = $this->askForKeyName($defaultKeyName);
            $privateKeyPath = $this->getPrivateKeyPath($keyName);
            $publicKeyPath = $this->getPublicKeyPath($privateKeyPath);
        }

        $returnCode = $this->generateSSHKeyPair($email, $privateKeyPath);

        if ($returnCode === 0) {
            $this->info('SSH key pair generated successfully!');
            $this->outputPublicKey($publicKeyPath);
        } else {
            $this->error('Failed to generate SSH key pair.');
        }
    }

    protected function askForKeyName($defaultKeyName)
    {
        return $this->ask("Enter a name for the new key pair (default is $defaultKeyName ):") ?: $defaultKeyName;
    }

    protected function getPrivateKeyPath($keyName)
    {
        return $_SERVER['HOME'] . "/.ssh/$keyName";
    }

    protected function getPublicKeyPath($privateKeyPath)
    {
        return "$privateKeyPath.pub";
    }

    protected function generateSSHKeyPair($email, $privateKeyPath)
    {
        exec("ssh-keygen -t rsa -b 4096 -C \"$email\" -f $privateKeyPath -N \"\"", $output, $returnCode);
        return $returnCode;
    }

    public function keyExists($publicKeyPath)
    {
        $keyExists = file_exists($publicKeyPath);

        if($keyExists) {
            $this->info("SSH key pair ( $publicKeyPath )  already exists ..");
            return true;
        }

        return false;
    }

}
