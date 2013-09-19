<?php

namespace Cerad\Bundle\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameScheduleController extends Controller
{
    public function indexAction()
    {
        $gameRepo = $this->get('cerad_game.game_repository');
        $games = $gameRepo->findAll();
        
        $tplData = array();
        $tplData['games'] = $games;
        $tplData['isAdmin'] = false;
        return $this->render('@CeradGame\Game\Schedule\GameScheduleIndex.html.twig',$tplData);
    }
}
