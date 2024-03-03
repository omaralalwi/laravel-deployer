<?php

namespace Omaralalwi\LaravelDeployer\Console\Commands;

use Illuminate\Console\Command;
use Omaralalwi\LaravelDeployer\Services\DeploymentManager;
use Omaralalwi\LaravelDeployer\Services\ConfigurationReader;

class DeployCommand extends Command
{
    private $deploymentManager;
    protected $signature = 'deploy:publish {branch?}';
    protected $description = 'Deploy project and execute all related commands';

    public function __construct(DeploymentManager $deploymentManager)
    {
        parent::__construct();
        $this->deploymentManager = $deploymentManager;
    }

    public function handle()
    {
        $branch = $this->argument('branch') ?? null;
        $this->deploymentManager->deploy($branch);
    }
}
