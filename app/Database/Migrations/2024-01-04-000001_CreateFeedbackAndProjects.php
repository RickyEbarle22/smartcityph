<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFeedbackAndProjects extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'     => ['type' => 'INT', 'unsigned' => true],
            'service_id'  => ['type' => 'INT', 'unsigned' => true],
            'rating'      => ['type' => 'TINYINT', 'constraint' => 1],
            'comment'     => ['type' => 'TEXT', 'null' => true],
            'is_approved' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('service_id');
        $this->forge->addKey('user_id');
        $this->forge->createTable('feedback', true);

        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'description' => ['type' => 'TEXT', 'null' => true],
            'agency'      => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'budget'      => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'status'      => ['type' => 'ENUM("planned","ongoing","completed","cancelled")', 'default' => 'planned'],
            'region_id'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'start_date'  => ['type' => 'DATE', 'null' => true],
            'end_date'    => ['type' => 'DATE', 'null' => true],
            'progress'    => ['type' => 'INT', 'default' => 0],
            'image'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('region_id');
        $this->forge->addKey('status');
        $this->forge->createTable('projects', true);
    }

    public function down()
    {
        $this->forge->dropTable('projects', true);
        $this->forge->dropTable('feedback', true);
    }
}
