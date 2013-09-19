<?php

namespace Cerad\Bundle\GameBundle\Entity;

use Doctrine\ORM\EntityRepository;

use Cerad\Bundle\GameBundle\Entity\Project as ProjectEntity;


class ProjectRepository extends EntityRepository
{   
    public function createProject($params = null) { return new ProjectEntity($params); }

    /* ==========================================================
     * Find stuff
     */
    public function find($id)
    {
        return $id ? parent::find($id) : null;
    }
    public function findByFed($id)
    {
        if (!$id) return null;
        
        $repo = $this->_em->getRepository('CeradPersonBundle:PersonFed');
        
        $fed = $repo->find($id); 
        
        if ($fed) return $fed->getPerson();
        
        return null;
    }
    /* ==========================================================
     * Persistence
     */
    public function save($entity)
    {
        if ($entity instanceof ProjectEntity) 
        {
            $em = $this->getEntityManager();

            return $em->persist($entity);
        }
        throw new \Exception('Wrong type of entity for save');
    }
    public function commit()
    {
       $em = $this->getEntityManager();
       return $em->flush();
    }
    /* ====================================================
     * Hashes up array values
     */
    public function hash($value)
    {
        if (is_array($value))
        {
            $array = $value;
            $value = null;
            
            // Trim and cat
            array_walk($array, function($val) use (&$value) { $value .= trim($val); });
        }
        $value = strtoupper(str_replace(array(' ','~','-'),'',$value));
        
        return $value;    
    }
    /* ================================================
     * Return a list of project ids
     */
    public function queryProjectIds($criteria = array())
    {
        $seasons    = $this->getArrayValue($criteria,'seasons'   );
        $sports     = $this->getArrayValue($criteria,'sports'    );
        $domains    = $this->getArrayValue($criteria,'domains'   );
        $domainSubs = $this->getArrayValue($criteria,'domainSubs');
        
        // Build query
        $qb = $this->createQueryBuilder('project');

        $qb->select('project.id');
        
        if ($seasons)
        {
            $qb->andWhere('project.season IN (:seasons)');
            $qb->setParameter('seasons',$seasons);
        }
        if ($sports)
        {
            $qb->andWhere('project.sport IN (:sports)');
            $qb->setParameter('sports',$sports);
        }
        if ($domains)
        {
            $qb->andWhere('project.domain IN (:domains)');
            $qb->setParameter('domains',$domains);
        }
        if ($domainSubs)
        {
            $qb->andWhere('project.domainSub IN (:domainSubs)');
            $qb->setParameter('domainSubs',$domainSubs);
        }
        $items = $qb->getQuery()->getArrayResult();
        
        $ids = array();
        foreach($items as $item)
        {
            $ids[] = $item['id'];
        }
        return $ids;
    }
    /* -----------------------------------------------------
     * Load a set of domains
     */
    public function queryDomainChoices($criteria = array())
    {
        $sports = $this->getArrayValue($criteria,'sports');
        
        // Build query
        $qb = $this->createQueryBuilder('project');

        $qb->select('distinct project.domain');
        
        if ($sports)
        {
            $qb->andWhere('project.sport IN (:sports)');
            $qb->setParameter('sports',$sports);
        }
        $qb->addOrderBy('project.domain');
       
        $items = $qb->getQuery()->getArrayResult();
        
        $choices = array();
        foreach($items as $item)
        {
            $choices[$item['domain']] = $item['domain'];
        }
        return $choices;
    }
    public function queryDomainSubChoices($criteria = array())
    {
        $sports  = $this->getArrayValue($criteria,'sports');
        $domains = $this->getArrayValue($criteria,'domains');
        
        // Build query
        $qb = $this->createQueryBuilder('project');

        $qb->select('distinct project.domainSub, project.domain');
        
        if ($sports)
        {
            $qb->andWhere('project.sport IN (:sports)');
            $qb->setParameter('sports',$sports);
        }
        if ($domains)
        {
            $qb->andWhere('project.domain IN (:domains)');
            $qb->setParameter('domains',$domains);
        }
        $qb->addOrderBy('project.domain, project.domainSub');
       
        $items = $qb->getQuery()->getArrayResult();
        
        $choices = array();
        foreach($items as $item)
        {
            $choices[$item['domainSub']] = $item['domain'] . ' ' . $item['domainSub'];
        }
        return $choices;
    }
    protected function getScalerValue($criteria,$name)
    {
        if (!isset($criteria[$name])) return null;

        return $criteria[$name];
    }
    protected function getArrayValue($criteria,$name)
    {
        if (!isset($criteria[$name])) return null;
        
        $value = $criteria[$name];
        
        if (!is_array($value)) return array($value);
        
        if (count($value) < 1) return null;
        
        // This nonsense filters out 0 or null values
        $values  = $value;
        $valuesx = array();
        foreach($values as $value)
        {
            if ($value) $valuesx[] = $value;
        }
        if (count($valuesx) < 1) return null;
        
        return $valuesx;
    }

}
?>
