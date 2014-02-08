<?php
namespace Cerad\Bundle\ProjectBundle\Model;

/* ===============================================================
 * First show at combining a doctrine entity with yaml metadata
 */
class Project
{
    protected $key;
    protected $name;
    protected $role;   // Tournament, Season
    protected $slug1;  // If active
    protected $slug2;  // If not active
    
    protected $status = 'Active';
     
    // Should not really be necessary except for hash?
    protected $season;
    protected $sport;
    protected $domain;
    protected $domainSub;
   
    public function getKey()  { return $this->key;  }
    public function getName() { return $this->name; }
    public function getRole() { return $this->role; }
    
    public function getSeason()    { return $this->season;  }
    public function getStatus()    { return $this->status;  }
    
    public function getSport ()    { return $this->sport;  }
    public function getDomain()    { return $this->domain; }
    public function getDomainSub() { return $this->domainSub; }
    
    public function setKey      ($value) { $this->key    = $value; }
    public function setName     ($value) { $this->name   = $value; }
    public function setRole     ($value) { $this->role   = $value; }
    public function setSeason   ($value) { $this->season = $value; }
    public function setStatus   ($value) { $this->status = $value; }
    
    public function setSport    ($value) { $this->sport     = $value; }
    public function setDomain   ($value) { $this->domain    = $value; }
    public function setDomainSub($value) { $this->domainSub = $value; }
    
    /* =========================================
     * Debugging
     */
}
?>
