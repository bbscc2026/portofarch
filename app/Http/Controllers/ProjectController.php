<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $projects = Project::published()->get();
        $category = $request->string('category')->toString();

        return view('projects.index', [
            'projects' => $category ? $projects->where('category', $category)->values() : $projects,
            'categories' => $projects->pluck('category')->unique()->values(),
            'activeCategory' => $category,
        ]);
    }

    public function show(Project $project): View
    {
        abort_unless($project->is_published, 404);

        $project->load('images', 'pressArticles');

        $published = Project::published()->get(['id', 'title', 'slug', 'cover_image', 'category']);
        $index = $published->search(fn (Project $p) => $p->id === $project->id);

        return view('projects.show', [
            'project' => $project,
            'next' => $published->get(($index + 1) % $published->count()),
        ]);
    }
}
