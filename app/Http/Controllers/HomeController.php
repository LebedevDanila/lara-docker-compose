<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends BaseController
{

    public function index() {
        return view('index', ['data' => $this->data]);
    }

    public function search(Request $request)
    {
        # code...
    }

}
