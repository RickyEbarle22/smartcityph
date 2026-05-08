<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRegionsTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug'       => ['type' => 'VARCHAR', 'constraint' => 160],
            'code'       => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'type'       => ['type' => 'ENUM("region","province","city","municipality")', 'default' => 'region'],
            'parent_id'  => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'latitude'   => ['type' => 'DECIMAL', 'constraint' => '10,7', 'null' => true],
            'longitude'  => ['type' => 'DECIMAL', 'constraint' => '10,7', 'null' => true],
            'population' => ['type' => 'INT', 'null' => true],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey('parent_id');
        $this->forge->addKey('type');
        $this->forge->createTable('regions', true);
    }

    public function down()
    {
        $this->forge->dropTable('regions', true);
    }
}
