<?php

namespace Alborq\DataTokenBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DataTokenCleanerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('AlborqDataToken:clear')
            ->setDescription('Supprimer tout les token Outdated')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tokenManager = $this->getContainer()->get('alborq.data_token');

        $tokenOutdated = $tokenManager->findOutdatedToken();
        $tokenTotal = $tokenManager->countToken();
        $tokenDeleted = 0;

        foreach($tokenOutdated as $token){
            $tokenManager->delete($token);
            $tokenDeleted++;
        }

        $output->writeln($tokenDeleted.' token ont ete supprimer');
        $output->writeln('Il reste '.$tokenTotal.' token dans la base');
    }
}