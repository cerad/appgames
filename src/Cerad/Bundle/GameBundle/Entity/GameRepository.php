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
    public function findFed($id)
    {
        if (!$id) return null;
        $repo = $this->_em->getRepository('CeradPersonBundle:PersonFed');
        return $repo->find($id);        
    }
    public function findPlan($id)
    {
        if (!$id) return null;
        $repo = $this->_em->getRepository('CeradPersonBundle:PersonPlan');
        return $repo->find($id);        
    }
    public function findPersonPerson($id)
    {
        if (!$id) return null;
        $repo = $this->_em->getRepository('CeradPersonBundle:PersonPerson');
        return $repo->find($id);        
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
}
?>
