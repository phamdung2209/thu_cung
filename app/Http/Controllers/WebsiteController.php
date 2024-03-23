<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:header_setup'])->only('header');
        $this->middleware(['permission:footer_setup'])->only('footer');
        $this->middleware(['permission:view_all_website_pages'])->only('pages');
        $this->middleware(['permission:website_appearance'])->only('appearance');
        $this->middleware(['permission:select_homepage'])->only('select_homepage');
        $this->middleware(['permission:authentication_layout_settings'])->only('authentication_layout_settings');
    }

    public function header(Request $request)
    {
        return view('backend.website_settings.header');
    }
    public function footer(Request $request)
    {
        $lang = $request->lang;
        return view('backend.website_settings.footer', compact('lang'));
    }
    public function pages(Request $request)
    {
        $page = Page::where('type', '!=', 'home_page')->get();
        return view('backend.website_settings.pages.index', compact('page'));
    }
    public function appearance(Request $request)
    {
        return view('backend.website_settings.appearance');
    }
    public function select_homepage(Request $request)
    {
        return view('backend.website_settings.select_homepage');
    }

    public function authentication_layout_settings(Request $request)
    {
        return view('backend.website_settings.authentication_layout_settings');
    }
}
