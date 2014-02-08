<?php
namespace Cerad\Bundle\ProjectBundle\Entity;

use Cerad\Bundle\ProjectBundle\Model\Project as ProjectModel;

/* ===============================================================
 * First show at combining a doctrine entity with yaml metadata
 */
class Project extends ProjectModel
{
    // Add this to make some sql queries easier since keys are unweildy
    protected $id;
    
}
?>
