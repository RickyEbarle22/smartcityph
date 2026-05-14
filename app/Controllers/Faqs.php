<?php

namespace App\Controllers;

use App\Models\FaqsModel;

class Faqs extends BaseController
{
    public function index()
    {
        $model    = new FaqsModel();
        $q        = trim((string) $this->request->getGet('q'));
        $category = trim((string) $this->request->getGet('category'));

        $list = $model->search($q ?: null, $category ?: null)->find();

        return view('faqs/index', [
            'title'       => 'Frequently Asked Questions — SmartCity PH',
            'faqs'        => $list,
            'categories'  => $model->categories(),
            'q'           => $q,
            'selCategory' => $category,
        ]);
    }
}
