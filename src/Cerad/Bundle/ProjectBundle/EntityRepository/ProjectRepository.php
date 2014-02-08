<?php
namespace Cerad\Bundle\ProjectBundle\EntityRepository;

use Cerad\Library\Doctrine\AbstractRepository;

//  Cerad\Bundle\GameBundle\Entity\Project as ProjectEntity;

class ProjectRepository extends AbstractRepository
{   
    public function createProject($params = null) { return $this->createEntity($params); }
    
    /* ================================================
     * Return a list of project ids
     */
    public function queryProjectKeys($criteria = array())
    {
        $seasons    = $this->getArrayValue($criteria,'seasons'   );
        $sports     = $this->getArrayValue($criteria,'sports'    );
        $domains    = $this->getArrayValue($criteria,'domains'   );
        $domainSubs = $this->getArrayValue($criteria,'domainSubs');
        
        // Build query
        $qb = $this->createQueryBuilder('project');

        $qb->select('distinct project.key');
        
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
        /* ================================================
         * These both return the same array structure
         * The scaler results alwys returns a flat structure, no sure if it is any faster
         */
      //$rows = $qb->getQuery()->getArrayResult();
        $rows = $qb->getQuery()->getScalarResult();
        
        $keys = array();
        array_walk($rows, function($row) use (&$keys) { $keys[] = $row['key']; });
        return $keys;
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
       
        $rows = $qb->getQuery()->getScalarResult();
        
        $choices = array();
        
        array_walk($rows, function($row) use (&$choices) { $choices[$row['domain']] = $row['domain']; });
        
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
        
        $rows = $qb->getQuery()->getScalarResult();
        $choices = array();
        array_walk($rows, function($row) use (&$choices) 
        { 
            $choices[$row['domainSub']] = $row['domain'] . ' ' . $row['domainSub']; 
        });
        return $choices;
    }
}
?>
