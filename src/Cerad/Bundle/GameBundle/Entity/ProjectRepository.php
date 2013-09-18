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

}
?>
