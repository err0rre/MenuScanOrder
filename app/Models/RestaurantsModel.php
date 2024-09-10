<?php

namespace App\Models;

use CodeIgniter\Model;

class RestaurantsModel extends Model
{
    protected $table = 'restaurants';
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['name', 'user_id', 'address', 'phone_number'];
    protected $returnType = 'array';
    protected $useTimestamps = false;
}