<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPerformanceIndexes extends Migration
{
    private function indexExists(string $table, string $indexName): bool
    {
        $db     = \Config\Database::connect();
        $result = $db->query(
            "SELECT COUNT(*) AS cnt FROM information_schema.STATISTICS
             WHERE table_schema = DATABASE()
               AND table_name   = ?
               AND index_name   = ?",
            [$table, $indexName]
        )->getRow();

        return $result && (int) $result->cnt > 0;
    }

    private function addKeyIfMissing(string $table, string|array $columns, string $indexName, bool $unique = false): void
    {
        if ($this->indexExists($table, $indexName)) {
            return;
        }

        $cols = is_array($columns) ? implode(', ', $columns) : $columns;
        $type = $unique ? 'UNIQUE' : 'INDEX';
        $this->db->query("ALTER TABLE `{$table}` ADD {$type} `{$indexName}` ({$cols})");
    }

    public function up()
    {
        // services
        $this->addKeyIfMissing('services', 'is_active',    'idx_services_is_active');
        $this->addKeyIfMissing('services', 'is_featured',  'idx_services_is_featured');
        $this->addKeyIfMissing('services', 'slug',         'idx_services_slug');
        $this->addKeyIfMissing('services', 'region_id',    'idx_services_region_id');
        $this->addKeyIfMissing('services', 'category',     'idx_services_category');

        // news
        $this->addKeyIfMissing('news', 'is_published', 'idx_news_is_published');
        $this->addKeyIfMissing('news', 'slug',         'idx_news_slug');
        $this->addKeyIfMissing('news', 'published_at', 'idx_news_published_at');

        // reports
        $this->addKeyIfMissing('reports', 'status',    'idx_reports_status');
        $this->addKeyIfMissing('reports', 'reference', 'idx_reports_reference');
        $this->addKeyIfMissing('reports', 'email',     'idx_reports_email');

        // users
        $this->addKeyIfMissing('users', 'email',     'idx_users_email');
        $this->addKeyIfMissing('users', 'is_active', 'idx_users_is_active');

        // regions
        $this->addKeyIfMissing('regions', 'slug', 'idx_regions_slug');

        // agencies
        $this->addKeyIfMissing('agencies', 'slug',      'idx_agencies_slug');
        $this->addKeyIfMissing('agencies', 'is_active', 'idx_agencies_is_active');
    }

    public function down()
    {
        $indexes = [
            'services' => ['idx_services_is_active', 'idx_services_is_featured', 'idx_services_slug', 'idx_services_region_id', 'idx_services_category'],
            'news'     => ['idx_news_is_published', 'idx_news_slug', 'idx_news_published_at'],
            'reports'  => ['idx_reports_status', 'idx_reports_reference', 'idx_reports_email'],
            'users'    => ['idx_users_email', 'idx_users_is_active'],
            'regions'  => ['idx_regions_slug'],
            'agencies' => ['idx_agencies_slug', 'idx_agencies_is_active'],
        ];

        foreach ($indexes as $table => $names) {
            foreach ($names as $name) {
                if ($this->indexExists($table, $name)) {
                    $this->db->query("ALTER TABLE `{$table}` DROP INDEX `{$name}`");
                }
            }
        }
    }
}
