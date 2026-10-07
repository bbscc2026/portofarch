<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\PressArticle;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $projects = Project::published()->get();

        return view('home', [
            'slides' => $this->slides($projects),
            'statements' => $this->statements(),
            'showcase' => $projects->sortByDesc('is_featured')->take(4)->values(),
            'projects' => $projects,
            'projectCount' => $projects->count(),
            'services' => Service::orderBy('sort_order')->get(),
            'clients' => Client::orderBy('sort_order')->get(),
            'press' => PressArticle::with('project')->orderBy('project_id')->orderBy('sort_order')->get(),
        ]);
    }

    /**
     * Hero statements from Site settings: one per line, "first row|second row".
     *
     * @return list<array{string, string}>
     */
    private function statements(): array
    {
        return collect(preg_split('/\R/', (string) Setting::get('hero_lines')))
            ->map(fn (string $line) => trim($line))
            ->filter()
            ->map(fn (string $line) => array_pad(array_map('trim', explode('|', $line, 2)), 2, ''))
            ->values()
            ->all();
    }

    /**
     * Hero background: the studio film (when set in Site settings) followed by project covers.
     *
     * @param  Collection<int, Project>  $projects
     * @return list<array{type: string, src: string, webm: ?string, poster: ?string, title: string, meta: ?string, url: string}>
     */
    private function slides(Collection $projects): array
    {
        $slides = [];

        if ($video = Setting::get('hero_video_mp4')) {
            $slides[] = [
                'type' => 'video',
                'src' => asset($video),
                'webm' => ($webm = Setting::get('hero_video_webm')) ? asset($webm) : null,
                'poster' => ($poster = Setting::get('hero_video_poster')) ? asset($poster) : null,
                'title' => Setting::get('hero_video_caption') ?: 'Studio film',
                'meta' => 'Film',
                'url' => route('projects.index'),
            ];
        }

        foreach ($projects->whereNotNull('cover_image')->take(4) as $project) {
            $slides[] = [
                'type' => 'image',
                'src' => $project->coverUrl(),
                'webm' => null,
                'poster' => null,
                'title' => $project->title,
                'meta' => "{$project->category} · {$project->location}",
                'url' => route('projects.show', $project),
            ];
        }

        return $slides;
    }
}
