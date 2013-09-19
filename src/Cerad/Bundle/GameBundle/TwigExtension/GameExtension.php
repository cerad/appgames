<?php
namespace Cerad\Bundle\GameBundle\TwigExtension;

class GameExtension extends \Twig_Extension
{
    protected $env;
    protected $levelRepo;
    
    public function getName() { return 'cerad_game_extension'; }
    
    public function __construct($levelRepo)
    {   
        $this->levelRepo = $levelRepo;        
    }
    public function initRuntime(\Twig_Environment $env)
    {
        parent::initRuntime($env);
        $this->env = $env;
    }
    protected function escape($string)
    {
        return twig_escape_filter($this->env,$string);
    }
    public function getFunctions()
    {
        return array(            
            'cerad_level_find' => new \Twig_Function_Method($this, 'findLevel'),
            'cerad_game_score' => new \Twig_Function_Method($this, 'gameScore'),
        );
    }
    public function gameScore($score)
    {
        if ($score === null) return '_:';
        return $score . ':';
    }
    public function findLevel($levelId)
    {
        return $this->levelRepo->find($levelId);
    }
}
?>
