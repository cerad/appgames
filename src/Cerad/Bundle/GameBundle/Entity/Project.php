<?php
namespace Cerad\Bundle\GameBundle\Entity;

class Project extends AbstractEntity
{
    protected $id;
    
    protected $status = 'Active';
     
    // Should not really be necessary except for hash?
    protected $season;
    protected $sport;
    protected $domain;
    protected $domainSub;
   
    public function getId() { return $this->id; }
    
    public function getSeason()    { return $this->season;  }
    public function getStatus()    { return $this->status;  }
    
    public function getSport ()    { return $this->sport;  }
    public function getDomain()    { return $this->domain; }
    public function getDomainSub() { return $this->domainSub; }
    
    public function setId       ($value) { $this->onPropertySet('id',       $value); }
    public function setSeason   ($value) { $this->onPropertySet('season',   $value); }
    public function setStatus   ($value) { $this->onPropertySet('status',   $value); }
    
    public function setSport    ($value) { $this->onPropertySet('sport',    $value); }
    public function setDomain   ($value) { $this->onPropertySet('domain',   $value); }
    public function setDomainSub($value) { $this->onPropertySet('domainSub',$value); }
    
    /* =========================================
     * Debugging
     */
    public function __toString()
    {
        return sprintf("Project %-8s %-8s %-8s %-10s %-12s %s\n",
            $this->status,
            $this->sport,
            $this->domain,
            $this->domainSub,
            $this->season,
            $this->id
        );
    }
}
?>
