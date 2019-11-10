<?php

use EasyCorp\Bundle\EasyDeployBundle\Deployer\DefaultDeployer;

return new class extends DefaultDeployer
{
    public function configure()
    {
        return $this->getConfigBuilder()
            // SSH connection string to connect to the remote server (format: user@host-or-IP:port-number)
            ->server('jhalt@jhalt.ddns.net')
            // the absolute path of the remote server directory where the project is deployed
            ->deployDir('/var/www/homenet')
            // the URL of the Git repository where the project code is hosted
            ->repositoryUrl('git@github.com:jhalt2/homenet')
            // the repository branch to deploy
            ->repositoryBranch('master')
        ;
    }

    // run some local or remote commands before the deployment is started
    public function beforeStartingDeploy()
    {
        // $this->runLocal('./vendor/bin/simple-phpunit');
    }

    // run some local or remote commands after the deployment is finished
    public function beforeFinishingDeploy()
    {
	$this->runRemote('composer dump-env prod');
        // $this->runRemote('{{ console_bin }} app:my-task-name');
        // $this->runLocal('say "The deployment has finished."');
    }

    public function beforePreparing()
    {
	    $this->runRemote('cp {{ deploy_dir }}/repo/.env {{ project_dir }}');
    }
};
