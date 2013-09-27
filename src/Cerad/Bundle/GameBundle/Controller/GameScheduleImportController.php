<?php
namespace Cerad\Bundle\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

class GameScheduleImportController extends Controller
{
    /* =====================================================
     * Wanted to just use GET but the dates mess up
     * Use the session trick for now
     */
    public function importAction(Request $request)
    {       
        // The search model
        $model = $this->createModel($request);
        
        // Simple custom form
        $form = $this->createModelForm($model);
        
        $form->handleRequest($request);

        if ($form->isValid()) // GET Request
        {   
            $model = $form->getData();
            
            $this->processModel($model);
            
          //$request->getSession()->set(self::SESSION_GAME_SCHEDULE_SEARCH,$modelPosted);
            
          //return $this->redirect($this->generateUrl('cerad_game_schedule'));
        }
        
        // Render
        $tplData = array();
        $tplData['form'] = $form->createView();
        return $this->render('@CeradGame\GameSchedule\Import\GameScheduleImportIndex.html.twig',$tplData);
    }
    /* ========================================================
     * Eventually want to move the file someplace safe and redirect
     * Then allow for mulitple import/processing passes
     * 
     * But for now, just process the silly thing
     */
    public function processModel($model)
    {
      //$file->move($dir, $file->getClientOriginalName());
        
        $file = $model['attachment'];
        
        echo sprintf("Max file size %d %d Valid: %d, Error: %d<br />\n",
            $file->getMaxFilesize(),$file->getClientSize(),$file->isValid(), $file->getError());
        
        $importFilePath = $file->getPathname();
        $clientFileName = $file->getClientOriginalName();
        
        $pathInfo = pathinfo($clientFileName);
        
        $parts = explode('_',$pathInfo['filename']);
        
        $paramsx = array();
        
        $paramsx['filepath'] = $importFilePath;
        
        $params = array_merge($paramsx,$pathInfo);
        
        $params['sport']  = 'Soccer';
        $params['domain'] = $parts[0];
        $params['season'] = $parts[1];
        $params['format'] = $parts[2];
        $params['suffix'] = $parts[3];
        
        $importServiceId = sprintf('cerad_game.schedule_Arbiter%s.import',$params['format']);
        $importService = $this->get($importServiceId);
        
        print_r($params); echo "<br />\n"; // die();
        $results = $importService->import($params);

        print_r($results);echo "<br />\n";
      //php398B.tmp NASOA_Fall2013_GamesWithSlots_20130927.xml
      //die($importFileName . ' ' . $clientFileName);
        
        return $model;
    }
    public function createModel(Request $request)
    {   
        // Build the search parameter information
        $model = array();
        $model['attachment'] = null;
        
        return $model;
    }
    protected function createModelForm($model)
    {
        $builder = $this->createFormBuilder($model);
        
        $builder->setAction($this->generateUrl('cerad_game_schedule_import'));
        $builder->setMethod('POST');
        
        $builder->add('attachment', 'file');
        
        $builder->add('import', 'submit', array(
            'label' => 'Import From File',
            'attr' => array('class' => 'import'),
        ));        
        return $builder->getForm();
    }
}
