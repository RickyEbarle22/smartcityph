<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSupportTables extends Migration
{
    public function up()
    {
        // ─── agencies ────────────────────────────────────────────
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 160],
            'acronym'     => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'category'    => ['type' => 'VARCHAR', 'constraint' => 80, 'null' => true],
            'website'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'email'       => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'phone'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'address'     => ['type' => 'TEXT', 'null' => true],
            'logo'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'head_name'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'head_title'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey('category');
        $this->forge->addKey('is_active');
        $this->forge->createTable('agencies', true);

        // ─── fois (Freedom of Information requests) ──────────────
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'reference'     => ['type' => 'VARCHAR', 'constraint' => 30],
            'full_name'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 150],
            'phone'         => ['type' => 'VARCHAR', 'constraint' => 25, 'null' => true],
            'agency_id'     => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'agency_name'   => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'request_title' => ['type' => 'VARCHAR', 'constraint' => 255],
            'description'   => ['type' => 'TEXT'],
            'purpose'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'        => ['type' => 'ENUM("pending","processing","fulfilled","denied")', 'default' => 'pending'],
            'response'      => ['type' => 'TEXT', 'null' => true],
            'responded_at'  => ['type' => 'DATETIME', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('reference');
        $this->forge->addKey('status');
        $this->forge->addKey('agency_id');
        $this->forge->createTable('fois', true);

        // ─── faqs ────────────────────────────────────────────────
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'question'   => ['type' => 'TEXT'],
            'answer'     => ['type' => 'TEXT'],
            'category'   => ['type' => 'VARCHAR', 'constraint' => 80, 'null' => true],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('category');
        $this->forge->addKey('is_active');
        $this->forge->createTable('faqs', true);

        // ─── add columns to services (idempotent guard) ──────────
        $db = \Config\Database::connect();
        if (! $db->fieldExists('is_popular', 'services')) {
            $this->forge->addColumn('services', [
                'is_popular' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'after' => 'is_active'],
            ]);
        }
        if (! $db->fieldExists('agency_id', 'services')) {
            $this->forge->addColumn('services', [
                'agency_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true, 'after' => 'agency'],
            ]);
        }

        // ─── add columns to projects ─────────────────────────────
        if (! $db->fieldExists('agency_id', 'projects')) {
            $this->forge->addColumn('projects', [
                'agency_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true, 'after' => 'agency'],
            ]);
        }
        if (! $db->fieldExists('amount_released', 'projects')) {
            $this->forge->addColumn('projects', [
                'amount_released' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0, 'after' => 'budget'],
            ]);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();

        if ($db->fieldExists('amount_released', 'projects')) {
            $this->forge->dropColumn('projects', 'amount_released');
        }
        if ($db->fieldExists('agency_id', 'projects')) {
            $this->forge->dropColumn('projects', 'agency_id');
        }
        if ($db->fieldExists('agency_id', 'services')) {
            $this->forge->dropColumn('services', 'agency_id');
        }
        if ($db->fieldExists('is_popular', 'services')) {
            $this->forge->dropColumn('services', 'is_popular');
        }

        $this->forge->dropTable('faqs', true);
        $this->forge->dropTable('fois', true);
        $this->forge->dropTable('agencies', true);
    }
}
