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

}
?>
