<?php
namespace Cerad\Bundle\ProjectBundle\EntityRepository;

use Symfony\Component\Yaml\Yaml;

/* =======================================================
 * Project meta data is all array for now
 * Needs to be wrapped in a real project entity
 */
class ProjectMetaRepository
{
    protected $metas = array();
    
    /* ============================================
     * All this does is load stash the meta data
     */
    public function __construct($files)
    {
        foreach($files as $file)
        {
            $meta = Yaml::parse(file_get_contents($file));
            $this->metas[$meta['meta']['info']['key']] = $meta['meta'];
        }
    }
    public function find($key)
    {
        return isset($this->metas[$key]) ? $this->metas[$key] : null;
    }
    public function findAll()
    {
        return $this->metas;    
    }
    public function findAllByStatus($status)
    {
        $metas = array();
        foreach($this->metas as $meta)
        {
            $info = $meta['info'];
            if ($status == $info['status']) $metas[$info['key']] = $meta;
        }
        return $metas;
    }
    public function findBySlug($slug)
    {
        $slug = strtolower($slug);
        
        foreach($this->metas as $meta)
        {
            $info = $meta['info'];
            
            if ($slug == strtolower($info['slug2'])) return $meta;
            
            if ($info['status'] != 'Active') break;
            
            if ($slug == strtolower($info['slug'])) return $meta;
        }
        return null;
    }
}

?>
