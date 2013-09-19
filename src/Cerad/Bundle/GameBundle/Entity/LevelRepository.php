<?php

namespace Cerad\Bundle\GameBundle\Entity;

use Doctrine\ORM\EntityRepository;

use Cerad\Bundle\GameBundle\Entity\Level as LevelEntity;

class LevelRepository extends EntityRepository
{   
    public function createLevel($params = null) { return new LevelEntity($params); }

    public function find($id)
    {
        return $id ? parent::find($id) : null;
    }
    /* ==========================================================
     * Persistence
     */
    public function save($entity)
    {
        if ($entity instanceof LevelEntity) 
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
     * Return a list of level ids
     */
    public function queryLevelIds($criteria = array())
    {
        $names      = $this->getArrayValue($criteria,'levels'    );
        $sports     = $this->getArrayValue($criteria,'sports'    );
        $domains    = $this->getArrayValue($criteria,'domains'   );
        $domainSubs = $this->getArrayValue($criteria,'domainSubs');
        
        // Build query
        $qb = $this->createQueryBuilder('level');

        $qb->select('level.id');
        
        if ($names)
        {
            $qb->andWhere('level.name IN (:names)');
            $qb->setParameter('names',$names);
        }
        if ($sports)
        {
            $qb->andWhere('level.sport IN (:sports)');
            $qb->setParameter('sports',$sports);
        }
        if ($domains)
        {
            $qb->andWhere('level.domain IN (:domains)');
            $qb->setParameter('domains',$domains);
        }
        if ($domainSubs)
        {
            $qb->andWhere('level.domainSub IN (:domainSubs)');
            $qb->setParameter('domainSubs',$domainSubs);
        }
      //echo $qb->getDql();
        $items = $qb->getQuery()->getArrayResult();
        
        $ids = array();
        foreach($items as $item)
        {
            $ids[] = $item['id'];
        }
        return $ids;
    }
    /* ==================================================
     * For level pick list
     * Should level have a sport?  Varsity etc
     */
    public function queryLevelChoices($criteria = array())
    {
        $sports     = $this->getArrayValue($criteria,'sports');
        $domains    = $this->getArrayValue($criteria,'domains');
        $domainSubs = $this->getArrayValue($criteria,'domainSubs');
        
        // Build query
        $qb = $this->createQueryBuilder('level');

        $qb->select('distinct level.name');
        
        if ($sports)
        {
            $qb->andWhere('level.sport IN (:sports)');
            $qb->setParameter('sports',$sports);
        }
        if ($domains)
        {
            $qb->andWhere('level.domain IN (:domains)');
            $qb->setParameter('domains',$domains);
        }
        if ($domainSubs)
        {
            $qb->andWhere('level.domainSub IN (:domainSubs)');
            $qb->setParameter('domainSubs',$domainSubs);
        }
        $qb->addOrderBy('level.name');
       
        $items = $qb->getQuery()->getArrayResult();
        
        $choices = array();
        foreach($items as $item)
        {
            $choices[$item['name']] = $item['name'];
        }
        return $choices;
    }
    /* ==========================================================
     * Maybe an abstract class would be nice after all
     */
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
