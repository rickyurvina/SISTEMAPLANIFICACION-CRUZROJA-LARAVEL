<?php

namespace App\Http\Controllers\Common;

use App\Abstracts\Http\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return|View
     */
    public function index()
    {
        return view('common.home.index',);
    }
}
