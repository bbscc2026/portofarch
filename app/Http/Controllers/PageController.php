<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Faq;
use App\Models\PressArticle;
use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class PageController extends Controller
{
    public function studio(): View
    {
        return view('studio', [
            'clients' => Client::orderBy('sort_order')->get(),
            'press' => PressArticle::with('project')->orderBy('project_id')->orderBy('sort_order')->get(),
            'projectCount' => Project::published()->count(),
            'image' => Project::published()->where('is_featured', true)->skip(1)->first(),
        ]);
    }

    public function services(): View
    {
        return view('services', [
            'services' => Service::orderBy('sort_order')->get(),
            'faqs' => Faq::orderBy('sort_order')->get(),
        ]);
    }
}
