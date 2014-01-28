<?php

namespace Cerad\Bundle\GameBundle\Entity;

/* ==============================================
 * Unique teams within a project
 * Basically a physical team
 * 
 * 
 */
class ProjectTeam
{
    const RolePhysical = 'Physical';
    const RoleFake     = 'Fake';

    protected $id;
    
    protected $projectKey;
    protected $levelKey;
    protected $role;          // Physical, Pool, Placeholder etc
    protected $name;          // name and levelKey should be uniqe withing a project
    protected $groupKey;      // for section matches?
    protected $link;          // Same team could be in multiple projects
    protected $status;
    
    
    public function getId()       { return $this->id;       }
    public function getSlot()     { return $this->slot;     }
    public function getRole()     { return $this->role;     }
    public function getGame()     { return $this->game;     }
    public function getTeam()     { return $this->team;     }
    public function getName()     { return $this->name;     }
    public function getLevelKey() { return $this->levelKey; }
    public function getScore()    { return $this->score;    }
    public function getStatus()   { return $this->status;   }
    public function getConduct()  { return $this->conduct;  }
    
    public function setSlot    ($value) { $this->onPropertySet('slot',     $value); }
    public function setRole    ($value) { $this->onPropertySet('role',     $value); }
    public function setGame    ($value) { $this->onPropertySet('game',     $value); }
    public function setTeam    ($value) { $this->onPropertySet('team',     $value); }
    public function setName    ($value) { $this->onPropertySet('name',     $value); }
    public function setLevelKey($value) { $this->onPropertySet('levelKey', $value); }
    public function setScore   ($value) { $this->onPropertySet('score',    $value); }
    public function setStatus  ($value) { $this->onPropertySet('status',   $value); }
    public function setConduct ($value) { $this->onPropertySet('conduct',  $value); }
    
    public function getRoleForSlot($slot)
    {
        switch($slot)
        {
            case self::SlotHome: return self::RoleHome;
            case self::SlotAway: return self::RoleAway;
        }
        return self::RoleSlot . $slot;
    }
}
?>
