<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table = 'item';
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['menu_id', 'name', 'category', 'description', 'price', 'image'];
    protected $returnType = 'array';
    protected $useTimestamps = false;
}