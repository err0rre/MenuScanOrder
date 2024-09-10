<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusFieldToUserTable extends Migration
{
    public function up()
    {
        // Adding a 'status' field to the 'User' table
        $fields = [
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => 'active',
                'after' => 'email' // Optional: Specify after which field to add 'status'
            ]
        ];
        $this->forge->addColumn('user', $fields);
    }

    public function down()
    {
        // Removing the 'status' field from the 'User' table
        $this->forge->dropColumn('user', 'status');
    }
}