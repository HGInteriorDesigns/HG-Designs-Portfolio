<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table            = 'projects';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'slug',
        'title',
        'description',
        'area',
        'location_name',
        'materials',
        'image_after',
        'image_before'
    ];
}
