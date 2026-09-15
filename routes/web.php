<?php

use App\Http\Controllers\Frontend\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/tools/{slug}', [SiteController::class, 'tool'])->name('tool.show');
Route::get('/categories/{slug}', [SiteController::class, 'category'])->name('category.show');
Route::get('/collections/{slug}', [SiteController::class, 'collection'])->name('collection.show');
Route::get('/guides', [SiteController::class, 'guidesIndex'])->name('guides.index');
Route::get('/guides/{slug}', [SiteController::class, 'guide'])->name('guide.show');
Route::get('/authors/{slug}', [SiteController::class, 'author'])->name('author.show');
Route::redirect('/author.html', '/authors/tj-verse', 301);
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::post('/contact', [SiteController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/privacy-policy', [SiteController::class, 'privacy'])->name('privacy');
Route::get('/terms-of-use', [SiteController::class, 'terms'])->name('terms');
Route::get('/disclaimer', [SiteController::class, 'disclaimer'])->name('disclaimer');
Route::get('/cookie-policy', [SiteController::class, 'cookiePolicy'])->name('cookie.policy');
Route::get('/sitemap.xml', [SiteController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SiteController::class, 'robots'])->name('robots');
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
