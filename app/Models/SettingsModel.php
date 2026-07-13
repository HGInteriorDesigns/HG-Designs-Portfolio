<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table            = 'settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'tagline', 
        'description', 
        'about_lead', 
        'about_body', 
        'about_quote', 
        'about_cite', 
        'email', 
        'location'
    ];
}
