<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['table_id', 'status', 'created_at', 'dishes'];
    protected $returnType = 'array';
    protected $useTimestamps = false;
}