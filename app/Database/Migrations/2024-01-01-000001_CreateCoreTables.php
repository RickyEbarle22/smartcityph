<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCoreTables extends Migration
{
    public function up()
    {
        // admins
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'username'   => ['type' => 'VARCHAR', 'constraint' => 80],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'full_name'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'role'       => ['type' => 'ENUM("superadmin","editor")', 'default' => 'editor'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('admins', true);

        // services
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'            => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug'            => ['type' => 'VARCHAR', 'constraint' => 160],
            'category'        => ['type' => 'VARCHAR', 'constraint' => 80],
            'short_desc'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'description'    => ['type' => 'LONGTEXT', 'null' => true],
            'icon'            => ['type' => 'VARCHAR', 'constraint' => 60, 'default' => 'fa-cog'],
            'image'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'requirements'    => ['type' => 'TEXT', 'null' => true],
            'steps'           => ['type' => 'TEXT', 'null' => true],
            'fee'             => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'processing_time' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'office'          => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'contact'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'website'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'agency'          => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'region_id'       => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'is_nationwide'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_featured'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_active'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'avg_rating'      => ['type' => 'DECIMAL', 'constraint' => '3,2', 'default' => 0],
            'total_ratings'   => ['type' => 'INT', 'default' => 0],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey('category');
        $this->forge->addKey('region_id');
        $this->forge->createTable('services', true);

        // news
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'title'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'         => ['type' => 'VARCHAR', 'constraint' => 260],
            'excerpt'      => ['type' => 'VARCHAR', 'constraint' => 400, 'null' => true],
            'body'         => ['type' => 'LONGTEXT', 'null' => true],
            'image'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'category'     => ['type' => 'VARCHAR', 'constraint' => 80],
            'author'       => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'Admin'],
            'tags'         => ['type' => 'TEXT', 'null' => true],
            'region_id'    => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'is_featured'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_published' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'published_at' => ['type' => 'DATETIME', 'null' => true],
            'views'        => ['type' => 'INT', 'default' => 0],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey('category');
        $this->forge->createTable('news', true);

        // reports
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'reference'    => ['type' => 'VARCHAR', 'constraint' => 30],
            'user_id'      => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'full_name'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'phone'        => ['type' => 'VARCHAR', 'constraint' => 25, 'null' => true],
            'category'     => ['type' => 'VARCHAR', 'constraint' => 60],
            'location'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'description'  => ['type' => 'TEXT'],
            'latitude'     => ['type' => 'DECIMAL', 'constraint' => '10,7', 'null' => true],
            'longitude'    => ['type' => 'DECIMAL', 'constraint' => '10,7', 'null' => true],
            'image'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'region_id'    => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'status'       => ['type' => 'ENUM("pending","reviewing","in_progress","resolved","rejected")', 'default' => 'pending'],
            'priority'     => ['type' => 'ENUM("low","medium","high","urgent")', 'default' => 'medium'],
            'admin_notes'  => ['type' => 'TEXT', 'null' => true],
            'assigned_to'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'resolved_at'  => ['type' => 'DATETIME', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('reference');
        $this->forge->addKey('status');
        $this->forge->addKey('user_id');
        $this->forge->createTable('reports', true);
    }

    public function down()
    {
        $this->forge->dropTable('reports', true);
        $this->forge->dropTable('news', true);
        $this->forge->dropTable('services', true);
        $this->forge->dropTable('admins', true);
    }
}
