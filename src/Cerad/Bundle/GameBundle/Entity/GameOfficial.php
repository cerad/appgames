<?php
namespace Cerad\Bundle\GameBundle\Entity;

/* ========================================================
 * Need a person value object
UPDATE game_officials SET assign_role = 'USER_ROLE' 
WHERE  game_officials.game_id IN 
(SELECT id FROM games WHERE DATE(games.dt_beg) IN ('2014-02-22','2014-03-01'))

 */
class GameOfficial
{
    protected $id;
    
    protected $game;
    protected $slot; // 1-5 for arbiter
    protected $role; // Referee, AR1 etc
    
    protected $assignRole;  // ROLE_USER, ROLE_ASSIGNOR
    protected $assignState; // Pending,Requested etc
    
    protected $personNameFull;
    protected $personEmail;
    protected $personPhone;
    protected $personBadge;
    protected $personKey;
    protected $personFedKey;
    protected $personOrgKey;
    
    protected $report;
    protected $status = 'Active';
    
    public function getId  () { return $this->id;     }
    public function getGame() { return $this->game;   }
    public function getSlot() { return $this->slot;   }
    public function getRole() { return $this->role;   }
    
    public function getAssignRole     () { return $this->assignRole;      }
    public function getAssignState    () { return $this->assignState;     }
    
    public function getPersonNameFull () { return $this->personNameFull;  }
    
    public function getPersonNameLast () { return $this->personNameLast;  }
    public function getPersonNameFirst() { return $this->personNameFirst; }
    public function getPersonEmail    () { return $this->personEmail;     }
    public function getPersonPhone    () { return $this->personPhone;     }
    public function getPersonBadge    () { return $this->personBadge;     }
    public function getPersonKey      () { return $this->personKey;       }
    
    public function getReport()          { return $this->report;          }
    public function getStatus()          { return $this->status;          }

    public function setGame($value) { $this->game = $value; }
    public function setSlot($value) { $this->slot = $value; } 
    public function setRole($value) { $this->role = $value; }
    
    public function setAssignRole     ($value) { $this->assignRole  = $value; }
    public function setAssignState    ($value) { $this->assignState = $value; }
     
    public function setPersonNameFull ($value) { $this->personNameFull  = $value; }
    public function setPersonNameLast ($value) { $this->personNameLast  = $value; }
    public function setPersonNameFirst($value) { $this->personNameFirst = $value; }
    public function setPersonEmail    ($value) { $this->personEmail     = $value; }
    public function setPersonPhone    ($value) { $this->personPhone     = $value; }
    public function setPersonBadge    ($value) { $this->personBadge     = $value; }
    public function setPersonKey      ($value) { $this->personKey       = $value; }
    public function setPersonFedKey   ($value) { $this->personFedKey    = $value; }
    public function setPersonOrgKey   ($value) { $this->personOrgKey    = $value; }
    
    public function setReport         ($value) { $this->report = $value; }
    public function setStatus         ($value) { $this->status = $value; }
    
    /* ===================================================
     * Are users allowed to self assign?
     */
    public function isUserAssignable()
    {
        return strpos($this->assignRole,'ROLE_USER') !== false ? true : false;
    }
    /* =========================================
     * Used to highlite objects
     */
    protected $selected;
    public function getSelected()       { return $this->selected; }
    public function setSelected($value) { $this->selected = $value; return $this; }
}

?>
