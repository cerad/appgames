<?php

namespace Cerad\Bundle\GameBundle\Entity;

use Doctrine\ORM\EntityRepository;

use Cerad\Bundle\GameBundle\Entity\Game as GameEntity;

class GameRepository extends EntityRepository
{   
    public function createGame($params = null) { return new GameEntity($params); }

    /* ==========================================================
     * Find stuff
     */
    public function find($id)
    {
        return $id ? parent::find($id) : null;
    }
    public function findOneByProjectNum($projectId,$num)
    {
        return $this->findOneBy(array('projectId' => $projectId, 'num' => $num));    
    }
    /* ==========================================================
     * Persistence
     */
    public function save($entity)
    {
        if ($entity instanceof GameEntity) 
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
    /* ========================================================
     * Generic schedule query
     * criteria is just an array
     */
    public function queryGameSchedule($criteria)
    {
        $nums = null;
        
        /* =================================================
         * Dates are always so much fun
         */
        $date1 = $this->getScalerValue($criteria,'date1');
        $date2 = $this->getScalerValue($criteria,'date2');
        
        // Need more work here, both are on then select two dates OR op
        $date1On = $this->getScalerValue($criteria,'date1On');
        $date2On = $this->getScalerValue($criteria,'date2On');
        
        $date1Ignore = $this->getScalerValue($criteria,'date1Ignore');
        $date2Ignore = $this->getScalerValue($criteria,'date2Ignore');
        
        if ($date1Ignore) $date1 = null;
        if ($date2Ignore) $date2 = null;
        
        if ($date1 && $date2 && ($date1 > $date2))
        {
            $tmp = $date1; $date1 = $date2; $date2 = $tmp;
        }
        
        /* ===========================================
         * Build the query
         */
        $qb = $this->createQueryBuilder('game');
        
        if ($date1)
        {
            $op = $date1On ? '=' : '>=';
            $qb->andWhere('DATE(game.dtBeg) ' . $op . ' (:date1)');
            $qb->setParameter('date1',$date1);
        }
        if ($date2)
        {
            $op = $date2On ? '=' : '<=';
            $qb->andWhere('DATE(game.dtEnd) ' . $op . ' (:date2)');
            $qb->setParameter('date2',$date2);
        }
        if ($nums)
        {
            $qb->andWhere('game.num IN (:nums)');
            $qb->setParameter('nums',$criteria['nums']);
        }
        echo $qb->getDql();
        
        return $qb->getQuery()->getResult();
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
        
        return array_values($value);
        
    }
}
?>
