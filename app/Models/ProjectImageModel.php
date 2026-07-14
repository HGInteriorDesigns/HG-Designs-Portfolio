<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectImageModel extends Model
{
    protected $table = 'project_images';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['project_id', 'image_path', 'image_type', 'caption', 'sort_order'];
    protected $useTimestamps = false;

    /**
     * Get all images for a project
     */
    public function getProjectImages($projectId)
    {
        return $this->where('project_id', $projectId)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Get images by type for a project
     */
    public function getImagesByType($projectId, $type)
    {
        return $this->where('project_id', $projectId)
                    ->where('image_type', $type)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Delete all images for a project
     */
    public function deleteProjectImages($projectId)
    {
        return $this->where('project_id', $projectId)->delete();
    }

    /**
     * Update sort order for images
     */
    public function updateSortOrder($imageId, $sortOrder)
    {
        return $this->update($imageId, ['sort_order' => $sortOrder]);
    }
}
