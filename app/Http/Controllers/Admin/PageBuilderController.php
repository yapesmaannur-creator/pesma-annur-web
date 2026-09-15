<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageBuilderController extends Controller
{
    public function index($slug)
    {
        $page = Page::with('sections')->where('slug', $slug)->firstOrFail();
        return view('admin.pages.builder.index', compact('page'));
    }
}
