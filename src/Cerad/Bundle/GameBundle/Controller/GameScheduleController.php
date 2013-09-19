<?php

namespace Cerad\Bundle\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameScheduleController extends Controller
{
    public function indexAction()
    {
        return $this->render('CeradGameBundle:Default:index.html.twig', array('name' => $name));
    }
}
