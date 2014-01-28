<?php
namespace Cerad\Bundle\GameBundle\Entity;

/* ==============================================
 * In most cases, these should be immutable
 * Or at least the hash fields
 * 
 * Use select distinct to get domans, subs and sports
 * 
 * Have not considered multiple regions under one area domain
 * Different levels for different seasons
 * 
 * Should levels have age/gender?
 * 
 *       Status   levelHash                 sport    domain   domainSub  level
V4Level: Active   SOCCERNASOAAHSAAFRESHMANB Soccer   NASOA    AHSAA      Freshman B
V4Level: Active   SOCCERNASOAAHSAAHSJVB     Soccer   NASOA    AHSAA      HS-JV B
V4Level: Active   SOCCERNASOAAHSAAHSJVG     Soccer   NASOA    AHSAA      HS-JV G
V4Level: Active   SOCCERNASOAAHSAAHSVARB    Soccer   NASOA    AHSAA      HS-Var B
V4Level: Active   SOCCERNASOAAHSAAHSVARG    Soccer   NASOA    AHSAA      HS-Var G
V4Level: Active   SOCCERNASOAAHSAAMSB       Soccer   NASOA    AHSAA      MS-B
V4Level: Active   SOCCERNASOAAHSAAMSG       Soccer   NASOA    AHSAA      MS-G
V4Level: Active   SOCCERNASOAMSSLMSB        Soccer   NASOA    MSSL       MS-B
V4Level: Active   SOCCERNASOAMSSLMSG        Soccer   NASOA    MSSL       MS-G
 */
class Level extends AbstractEntity
{
    protected $key;
    
    protected $name;
    protected $sport;
    protected $domain;
    protected $domainSub;
    
    protected $program; // Core/Extra/Regional/Premier etc
    protected $age;
    protected $gender;
    
    protected $status;
    
    protected $link;   // Future, allow linking the same level across multiple domains
    
    public function getKey()       { return $this->key;    }
    public function getName()      { return $this->name;   }
    public function getLink()      { return $this->link;   }
    public function getStatus()    { return $this->status; }
    
    public function getSport()     { return $this->sport;  }
    public function getDomain()    { return $this->domain; }
    public function getDomainSub() { return $this->domainSub; }
    
    public function setKey      ($value) { $this->onPropertySet('key',      $value); }
    public function setName     ($value) { $this->onPropertySet('name',     $value); }
    public function setLink     ($value) { $this->onPropertySet('link',     $value); }
    public function setStatus   ($value) { $this->onPropertySet('status',   $value); }
    
    public function setSport    ($value) { $this->onPropertySet('sport',    $value); }
    public function setDomain   ($value) { $this->onPropertySet('domain',   $value); }
    public function setDomainSub($value) { $this->onPropertySet('domainSub',$value); }
    
}
?>
