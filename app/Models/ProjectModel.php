<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table            = 'projects';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'slug',
        'title',
        'description',
        'area',
        'location_name',
        'materials',
        'category',
        'image_after',
        'image_before'
    ];

    /**
     * Get project with images
     */
    public function getProjectWithImages($id)
    {
        $project = $this->find($id);
        if ($project) {
            $imageModel = new ProjectImageModel();
            $project['images'] = $imageModel->getProjectImages($id);
        }
        return $project;
    }

    /**
     * Get all projects with images
     */
    public function getAllWithImages()
    {
        $projects = $this->findAll();
        $imageModel = new ProjectImageModel();
        
        foreach ($projects as &$project) {
            $project['images'] = $imageModel->getProjectImages($project['id']);
        }
        
        return $projects;
    }

    /**
     * Get projects by category with images
     */
    public function getByCategoryWithImages($category)
    {
        $projects = $this->where('category', $category)->findAll();
        $imageModel = new ProjectImageModel();
        
        foreach ($projects as &$project) {
            $project['images'] = $imageModel->getProjectImages($project['id']);
        }
        
        return $projects;
    }
}
