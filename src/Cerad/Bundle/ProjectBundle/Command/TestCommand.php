<?php
namespace Cerad\Bundle\ProjectBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
//  Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName       ('cerad_project:test');
        $this->setDescription('Project Test');
        $this->addArgument   ('slug',InputArgument::OPTIONAL,'Project Slug');
    }
    protected function getService  ($id)   { return $this->getContainer()->get($id); }
    protected function getParameter($name) { return $this->getContainer()->getParameter($name); }
        
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectMetaRepo = $this->getService('cerad_project__project_meta_repository');
        
        $projectMetas = $projectMetaRepo->findAll();
        foreach($projectMetas as $key => $meta)
        {
            $info = $meta['info'];
            
            $output->writeln($key);
            $output->writeln($info['key']);
        }
        $slug = $input->getArgument('slug');
        if (!$slug) return;
        
        $projectMeta = $projectMetaRepo->findBySlug($slug);
        $output->writeln($projectMeta['info']['key']);
         
        $output->writeln('Project Test ' . $slug);
        
        return;
    }
}
?>
