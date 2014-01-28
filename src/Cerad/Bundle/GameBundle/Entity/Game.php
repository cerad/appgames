<?php
namespace Cerad\Bundle\GameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/* ==============================================
 * Each game has a project and a level
 * game.num is unique within project
 */
class Game extends AbstractEntity
{
    const RoleGame = 'Game';

    protected $id;
    
    protected $num;   // Unique within project
    protected $role = self::RoleGame;
    
    protected $groupKey;
    protected $groupType;
    
    protected $link;   // Maybe to link crews?
    
    protected $dtBeg; // DateTime begin
    protected $dtEnd; // DateTime end
    
    protected $levelKey;
    protected $projectKey;
    
    protected $field;
    
    protected $status;
    
    protected $teams;
    protected $officials;
    
    public function getId()      { return $this->id;      }
    public function getNum()     { return $this->num;     }
    public function getRole()    { return $this->role;    }
    public function getPool()    { return $this->pool;    }
    public function getLink()    { return $this->link;    }
    public function getField()   { return $this->field;   }
    public function getDtBeg()   { return $this->dtBeg;   }
    public function getDtEnd()   { return $this->dtEnd;   }
    public function getStatus()  { return $this->status;  }
    
    public function getLevelKey()   { return $this->levelKey;   }
    public function getProjectKey() { return $this->projectKey; }
    
    public function setNum      ($value) { $this->onPropertySet('num',      $value); }
    public function setLink     ($value) { $this->onPropertySet('link',     $value); }
    public function setRole     ($value) { $this->onPropertySet('role',     $value); }
    public function setPool     ($value) { $this->onPropertySet('pool',     $value); }
    public function setField    ($value) { $this->onPropertySet('field',    $value); }
    public function setDtBeg    ($value) { $this->onPropertySet('dtBeg',    $value); }
    public function setDtEnd    ($value) { $this->onPropertySet('dtEnd',    $value); }
    public function setStatus   ($value) { $this->onPropertySet('status',   $value); }
    
    public function setLevelKey  ($value) { $this->onPropertySet('levelKey',  $value); }
    public function setProjectKey($value) { $this->onPropertySet('projectKey',$value); }
    
    /* =======================================
     * Create factory
     * Too many parameters
     */
    public function __construct()
    {
        $this->teams   = new ArrayCollection();
        $this->persons = new ArrayCollection();
    }
    /* =======================================
     * Team stuff
     */
   public function createGameTeam($params = null) { return new GameTeam($params); }
   
   public function getTeams($sort = true) 
    { 
        if (!$sort) return $this->teams;
        
        $items = $this->teams->toArray();
        
        ksort ($items);
        return $items; 
    }
    public function addTeam($team)
    {
        $this->teams[$team->getSlot()] = $team;
        
        $team->setGame($this);
        
        $this->onPropertyChanged('teams');
    }
    public function getTeamForSlot($slot,$autoCreate = true)
    {
        if (isset($this->teams[$slot])) return $this->teams[$slot];
        
        if (!$autoCreate) return null;
        
        $gameTeam = $this->createGameTeam();
        $gameTeam->setSlot($slot);
        $role = $gameTeam->getRoleForSlot($slot);
        $gameTeam->setRole($role);
        
        $this->addTeam($gameTeam);
        return $gameTeam;
    }
    public function getHomeTeam($autoCreate = true) { return $this->getTeamForSlot(GameTeam::SlotHome,$autoCreate); }
    public function getAwayTeam($autoCreate = true) { return $this->getTeamForSlot(GameTeam::SlotAway,$autoCreate); }
    
    /* =======================================
     * Person stuff
     */
    public function getPersons($sort = true) 
    { 
        if (!$sort) return $this->persons;
        
        $items = $this->persons->toArray();
        
        ksort ($items);
        return $items; 
    }
    public function addPerson($person)
    {
        $this->persons[$person->getSlot()] = $person;
        
        $person->setGame($this);
    }
    public function getPersonForSlot($slot)
    {
        if (isset($this->persons[$slot])) return $this->persons[$slot];
        
        return null;
    }
    /* =========================================
     * Debugging
     * TODO: Fix Up
     */
    public function __toString()
    {
        ob_start();

        echo sprintf("Game %-6s %-4s %6s %-8s %s   %-8s %-10s %s\n",
            $this->status,
            $this->role,
            $this->num,
            $this->projectKey,
            $this->dtBeg->format('d M Y H:i:s A'),
            $this->level->getDomainSub(),
            $this->level->getName(),
            $this->field->getName()
        );
        foreach($this->teams as $team)
        {
            echo $team . "\n";
        }
        return ob_get_clean();
    }
}
?>
