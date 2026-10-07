{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach (['home', 'projects.index', 'studio', 'services', 'contact'] as $name)
        <url><loc>{{ route($name) }}</loc></url>
    @endforeach
    @foreach ($projects as $project)
        <url><loc>{{ route('projects.show', $project) }}</loc><lastmod>{{ $project->updated_at->toAtomString() }}</lastmod></url>
    @endforeach
</urlset>
