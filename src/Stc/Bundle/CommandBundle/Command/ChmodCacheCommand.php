<?php

namespace Stc\Bundle\CommandBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Oro\Bundle\InstallerBundle\CommandExecutor;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

class ChmodCacheCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('stc:cache:chmod')
            ->setDescription('Changes permissions on dev & prod directories to 777');

    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $commandExecutor = new CommandExecutor(
            'prod',
            $output,
            $this->getApplication(),
            $this->getContainer()->get('oro_cache.oro_data_cache_manager')
        );
        $commandExecutor->setDefaultTimeout(2500);


        exec('cd '.__DIR__.'/../../../../../; '.'chmod -R 777 app/cache/');

    }
}
