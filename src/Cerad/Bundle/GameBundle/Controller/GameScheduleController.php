<?php
namespace Cerad\Bundle\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

class GameScheduleController extends Controller
{
    const SESSION_GAME_SCHEDULE_SEARCH = 'gameScheduleSearch';
    
    /* =====================================================
     * Wanted to just use GET but the dates mess up
     * Use the session trick for now
     */
    public function indexAction(Request $request)
    {
        // The search model
        $model = $this->getModel();
        
        // Pull form session
        $session = $request->getSession();
        if ($session->has(self::SESSION_GAME_SCHEDULE_SEARCH))
        {
            $modelSession = $session->get(self::SESSION_GAME_SCHEDULE_SEARCH);
            $model = array_merge($model,$modelSession);
        }
        // The form stuff
        $searchFormType = $this->get('cerad_game.game_schedule_search.form_type');
        $searchForm = $this->createForm($searchFormType,$model);
        
        $searchForm->handleRequest($request);

        if ($searchForm->isValid()) // GET Request
        {   
            $modelPosted = $searchForm->getData();
            
            $session->set(self::SESSION_GAME_SCHEDULE_SEARCH,$modelPosted);
            
            return $this->redirect($this->generateUrl('cerad_game_schedule'));
        }

        // Query for the games
        $gameRepo = $this->get('cerad_game.game_repository');
        $games = $gameRepo->queryGameSchedule($model);
        
        // And render
        $tplData = array();
        $tplData['searchForm'] = $searchForm->createView();
        $tplData['games']   = $games;
        $tplData['isAdmin'] = false;
        return $this->render('@CeradGame\Game\Schedule\GameScheduleIndex.html.twig',$tplData);
    }
    public function getModel()
    {   
        // Build the search parameter information
        $model = array();
        
        $model['domains']    = array('NASOA','ALYS');
        $model['domainSubs'] = array();
        
        $model['levels']  = array();
        $model['teams' ]  = array();
        $model['fields']  = array();
        
        $model['seasons']  = array('Fall2013');
        $model['sports']   = array('Soccer');
        $model['statuses'] = array();
        
        $date1 = new \DateTime();
        $date2 = clone $date1;
        $date2->add(new \DateInterval('P10D'));
        
        $model['date1'] = $date1->format('Y-m-d');
        $model['date2'] = $date2->format('Y-m-d');
        
        $model['date1On'] = false;
        $model['date2On'] = false;
        
        $model['date1Ignore'] = false;
        $model['date2Ignore'] = false;
        
        return $model;
    }
}
