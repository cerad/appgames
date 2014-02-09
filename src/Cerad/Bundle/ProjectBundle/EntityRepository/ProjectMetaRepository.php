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
    public function findOneByKey($key)
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
    public function findOneBySlug($slug)
    {
        $slug = trim(strtolower($slug));
        if (!$slug) return null;
        
        foreach($this->projects as $project)
        {
            $slugx = strtolower($project->getSlug());
            
            if ($slug == $slugx) return $project;
            
            if ($project->getStatus() != 'Active') break;

            if ($slug == substr($slugx,0,strlen($slug))) return $project;
        }
        return null;
    }
}
?>