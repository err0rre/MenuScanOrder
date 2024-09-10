<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageFieldToItemTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('item', [
            'image' => [
                'type' => 'LONGBLOB',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('item', 'image');
    }
}

