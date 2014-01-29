<?php
namespace Cerad\Bundle\GameBundle\Entity;
/*
CREATE TABLE projects (
 * id VARCHAR(80) NOT NULL, 
 * name VARCHAR(80) DEFAULT NULL, 
 * season VARCHAR(20) NOT NULL, 
 * sport VARCHAR(20) NOT NULL, 
 * domain VARCHAR(20) NOT NULL, 
 * domainSub VARCHAR(40) NOT NULL, 
 * status VARCHAR(20) DEFAULT NULL, 
 * INDEX project_season_index (season), 
 * INDEX project_sport_index (sport), 
 * INDEX project_domain_index (domain), 
 * INDEX project_domain_sub_index (domainSub), 
 * PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
 * 
 */
class Project extends AbstractEntity
{
    protected $key;
    protected $name;
    
    protected $status = 'Active';
     
    // Should not really be necessary except for hash?
    protected $season;
    protected $sport;
    protected $domain;
    protected $domainSub;
   
    public function getKey()  { return $this->key;  }
    public function getName() { return $this->name; }
    
    public function getSeason()    { return $this->season;  }
    public function getStatus()    { return $this->status;  }
    
    public function getSport ()    { return $this->sport;  }
    public function getDomain()    { return $this->domain; }
    public function getDomainSub() { return $this->domainSub; }
    
    public function setKey      ($value) { $this->key    = $value; }
    public function setName     ($value) { $this->name   = $value; }
    public function setSeason   ($value) { $this->season = $value; }
    public function setStatus   ($value) { $this->status = $value; }
    
    public function setSport    ($value) { $this->sport     = $value; }
    public function setDomain   ($value) { $this->domain    = $value; }
    public function setDomainSub($value) { $this->domainSub = $value; }
    
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
            $this->key
        );
    }
}
?>
