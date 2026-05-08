<?php

namespace App\Controllers;

use App\Models\NewsModel;

class News extends BaseController
{
    public function index()
    {
        $news     = new NewsModel();
        $category = $this->request->getGet('category');

        $builder = $news->where('is_published', 1);
        if ($category) {
            $builder = $builder->where('category', $category);
        }

        $featured = $news->featured();
        $items    = $builder->orderBy('published_at', 'DESC')->paginate(9);
        $pager    = $news->pager;

        $cats = $news->select('category')
            ->where('is_published', 1)
            ->groupBy('category')
            ->find();

        return view('news/index', [
            'title'      => 'News & Announcements — SmartCity PH',
            'items'      => $items,
            'pager'      => $pager,
            'featured'   => $featured,
            'categories' => array_column($cats, 'category'),
            'selCategory'=> $category,
        ]);
    }

    public function detail(string $slug)
    {
        $news    = new NewsModel();
        $article = $news->findBySlug($slug);

        if (! $article) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $news->incrementViews((int) $article['id']);

        $related = $news->where('category', $article['category'])
            ->where('id !=', $article['id'])
            ->where('is_published', 1)
            ->orderBy('published_at', 'DESC')
            ->limit(3)
            ->find();

        return view('news/detail', [
            'title'    => $article['title'] . ' — SmartCity PH',
            'article'  => $article,
            'related'  => $related,
        ]);
    }
}
