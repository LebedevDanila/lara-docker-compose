<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;

class HomeController extends BaseController
{

    public function index(CategoryService $category_service) {
        $this->data['view_file'] = 'home';

        var_dump($category_service->get(['id' => 5]));
        die();

        return view('index', ['data' => $this->data]);
    }

    public function search(Request $request)
    {
        # code...
    }

}
