<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'first_name'  => ['type' => 'VARCHAR', 'constraint' => 60],
            'last_name'   => ['type' => 'VARCHAR', 'constraint' => 60],
            'email'       => ['type' => 'VARCHAR', 'constraint' => 150],
            'password'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'phone'       => ['type' => 'VARCHAR', 'constraint' => 25, 'null' => true],
            'address'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'region_id'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'avatar'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'is_verified' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'last_login'  => ['type' => 'DATETIME', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users', true);
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
