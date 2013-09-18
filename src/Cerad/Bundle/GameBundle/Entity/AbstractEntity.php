<?php

namespace Cerad\Bundle\GameBundle\Entity;

use Doctrine\Common\NotifyPropertyChanged,
    Doctrine\Common\PropertyChangedListener;

class AbstractEntity implements NotifyPropertyChanged
{
    /* ========================================================================
     * Property change stuff
     */
    protected $listeners = array();

    public function addPropertyChangedListener(PropertyChangedListener $listener)
    {
        $this->listeners[] = $listener;
    }    
    protected function onPropertyChanged($propName, $oldValue, $newValue)
    {
        foreach ($this->listeners as $listener) 
        {
            $listener->propertyChanged($this, $propName, $oldValue, $newValue);
        }
    }
    protected function onPropertySet($name,$newValue)
    {
        $oldValue = $this->$name;
        
        if ($oldValue === $newValue) return;
        if ($oldValue ==  $newValue) return;
        
        // Value changed
        $this->$name = $newValue;
        
        $this->onPropertyChanged($name,$oldValue,$newValue);    
    }
 }
?>
