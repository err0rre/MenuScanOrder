<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDishesFieldToOrderTable extends Migration
{
    public function up()
    {
        // Adding a 'Dishes' field to the 'Order' table
        $fields = [
            'dishes' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ]
        ];
        $this->forge->addColumn('order', $fields);
    }

    public function down()
    {
        // Removing the 'Dishes' field from the 'Order' table
        $this->forge->dropColumn('order', 'dishes');
    }
}