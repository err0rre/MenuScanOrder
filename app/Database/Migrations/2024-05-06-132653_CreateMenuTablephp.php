<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenuTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'restaurant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'menu_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('restaurant_id', 'restaurants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('menu');
    }

    public function down()
    {
        $this->forge->dropTable('menu');
    }
}
