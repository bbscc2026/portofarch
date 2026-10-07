<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/studio', [PageController::class, 'studio'])->name('studio');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

Route::get('/sitemap.xml', function () {
    return response()->view('sitemap', ['projects' => Project::published()->get(['slug', 'updated_at'])])
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

// Old WordPress URLs → new pages (keeps Google rankings and shared links working).
Route::permanentRedirect('/about-us', '/studio');
Route::permanentRedirect('/property', '/projects');
