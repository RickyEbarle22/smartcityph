<?php

namespace App\Controllers;

use App\Models\NewsModel;
use App\Models\ReportsModel;
use App\Models\ServicesModel;
use CodeIgniter\HTTP\ResponseInterface;

class Api extends BaseController
{
    public function reportStatus(string $reference): ResponseInterface
    {
        $row = (new ReportsModel())
            ->select('status, admin_notes, updated_at, resolved_at')
            ->where('reference', $reference)
            ->first();

        if (! $row) {
            return $this->json(['error' => 'not_found'], 404);
        }

        return $this->json($row);
    }

    public function latestNews(): ResponseInterface
    {
        $rows = (new NewsModel())
            ->select('id, title, slug, published_at')
            ->where('is_published', 1)
            ->orderBy('published_at', 'DESC')
            ->limit(3)
            ->find();

        return $this->json($rows);
    }

    public function featuredServices(): ResponseInterface
    {
        $rows = (new ServicesModel())
            ->select('id, name, slug, updated_at')
            ->where('is_featured', 1)
            ->where('is_active', 1)
            ->orderBy('updated_at', 'DESC')
            ->limit(6)
            ->find();

        return $this->json($rows);
    }

    private function json($payload, int $status = 200): ResponseInterface
    {
        return $this->response
            ->setStatusCode($status)
            ->setHeader('Content-Type', 'application/json; charset=UTF-8')
            ->setHeader('Cache-Control', 'no-store, max-age=0')
            ->setBody(json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
