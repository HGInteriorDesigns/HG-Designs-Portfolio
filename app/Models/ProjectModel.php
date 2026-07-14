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
            try {
                $imageModel = new ProjectImageModel();
                $project['images'] = $imageModel->getProjectImages($id);
            } catch (\Exception $e) {
                $project['images'] = [];
            }
        }
        return $project;
    }

    /**
     * Get all projects with images
     */
    public function getAllWithImages()
    {
        $projects = $this->findAll();
        
        try {
            $imageModel = new ProjectImageModel();
            foreach ($projects as &$project) {
                $project['images'] = $imageModel->getProjectImages($project['id']);
            }
        } catch (\Exception $e) {
            // If project_images table doesn't exist, set empty images array
            foreach ($projects as &$project) {
                $project['images'] = [];
            }
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
