<?php
namespace Cerad\Bundle\ProjectBundle\EntityRepository;

use Cerad\Bundle\ProjectBundle\Model\Project as ProjectModel;

use Symfony\Component\Yaml\Yaml;

class ProjectMetaRepository
{
    protected $projects = array();
    
    /* ============================================
     * All this does is load stash the meta data
     */
    public function __construct($files)
    {
        foreach($files as $file)
        {
            $meta = Yaml::parse(file_get_contents($file));
            $key = $meta['meta']['info']['key'];
            $project = new ProjectModel($meta['meta']);
            $this->projects[$key] = $project;
        }
    }
    public function find($key)
    {
        return isset($this->projects[$key]) ? $this->projects[$key] : null;
    }
    public function findAll()
    {
        return $this->projects;    
    }
    public function findAllByStatus($status)
    {
        $projects = array();
        foreach($this->projects as $project)
        {
            if ($status == $project->getStatus()) $projects[$project->getKey()] = $project;
        }
        return $projects;
    }
    public function findBySlug($slug)
    {
        $slug = strtolower($slug);
        
        foreach($this->projects as $project)
        {
            if ($slug == strtolower($project->getSlug2())) return $project;
            
            if ($project->getStatus() != 'Active') break;
            
            if ($slug == strtolower($project->getSlug1())) return $project;
        }
        return null;
    }
}
?>