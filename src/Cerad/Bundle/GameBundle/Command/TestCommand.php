<?php
namespace Cerad\Bundle\GameBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
//  Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends ContainerAwareCommand
{   
    protected function configure()
    {
        $this->setName       ('app_games:test');
        $this->setDescription('Test Repositories');
    }
    protected function getService  ($id)   { return $this->getContainer()->get($id); }
    protected function getParameter($name) { return $this->getContainer()->getParameter($name); }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {   
        $this->testProjectRepo();
        
    }
    protected function testProjectRepo()
    {   
        $projectRepo = $this->getService('cerad_project.project_repository');
        
        $domains = $projectRepo->queryDomainChoices();
        print_r($domains);
        
        $domainSubs = $projectRepo->queryDomainSubChoices();
        print_r($domainSubs);
        
        $projectKeys = $projectRepo->queryProjectKeys();
        print_r($projectKeys);
        
    }
}
?>
