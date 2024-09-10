<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['restaurant_id', 'menu_name'];
    protected $returnType = 'array';
    protected $useTimestamps = false;
}