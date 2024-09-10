<?php

namespace App\Models;

use CodeIgniter\Model;

class TableModel extends Model
{
    protected $table = 'table';
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['restaurant_id', 'table_number'];
    protected $returnType = 'array';
    protected $useTimestamps = false;
}