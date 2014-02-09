<?php
namespace Cerad\Bundle\ProjectBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerAware;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Symfony\Component\HttpKernel\KernelEvents;
//  Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

use Cerad\Bundle\ProjectBundle\ProjectEvents;

class ProjectEventListener extends ContainerAware implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array
        (
            KernelEvents::REQUEST => array(array('onKernelRequest', -8)), // Runs After RoleListener, before mdel listener

            ProjectEvents::FindProjectByKey  => array('onFindProjectByKey'  ),
            ProjectEvents::FindProjectBySlug => array('onFindProjectBySlug' ),
        );
    }
    protected function getProjectRepository()
    {
        return $this->container->get('cerad_project__project_meta_repository');
    }
    public function onKernelRequest(GetResponseEvent $event)
    {
        // Only process routes with a model
        $request = $event->getRequest();
        $projectSlug = $request->attributes->get('projectSlug');
        if (!$projectSlug) return;
       
        $project = $this->getProjectRepository()->findOneBySlug($projectSlug);
        
        if ($project)
        {
            $request->attributes->set('project',$project);
            return;
        }
        // TODO: deal with invalid project request
        die('requested ' . $projectSlug);
    }
    public function onFindProjectBySlug(Event $event)
    {
        // Lookup
        $event->stopPropagation();
        $event->project = $this->getProjectRepository()->findOneBySlug($event->slug);
        return;
    }
    public function onFindProjectByKey(Event $event)
    {
        // Lookup
        $event->stopPropagation();
        $event->project = $this->getProjectRepository()->findOneByKey($event->key);
        return;
    }
}
?>
