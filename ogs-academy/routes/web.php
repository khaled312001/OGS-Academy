<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public site routes
|--------------------------------------------------------------------------
*/
Route::get('/',                  [HomeController::class, 'index'])->name('home');
Route::get('/programs',          [ProgramController::class, 'index'])->name('programs.index');
Route::get('/programs/{program}',[ProgramController::class, 'show'])->name('programs.show');
Route::get('/articles',          [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}',[ArticleController::class, 'show'])->name('articles.show');
Route::get('/about',             [PageController::class, 'about'])->name('about');
Route::get('/contact',           [ContactController::class, 'show'])->name('contact');
Route::post('/contact',          [ContactController::class, 'store'])->name('contact.store');
Route::post('/inquiries',        [InquiryController::class, 'store'])->name('inquiries.store');

// SEO
Route::get('/sitemap.xml',       [SitemapController::class, 'index']);
Route::get('/robots.txt',        [SitemapController::class, 'robots']);

/*
|--------------------------------------------------------------------------
| Admin auth
|--------------------------------------------------------------------------
*/
Route::get('login', fn () => redirect()->route('admin.login'))->name('login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login',  [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminLoginController::class, 'login'])->name('login.submit');
    });
    Route::post('logout', [AdminLoginController::class, 'logout'])->middleware('auth')->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin dashboard
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('notifications/count', [Admin\DashboardController::class, 'notificationsCount'])->name('notifications.count');

    Route::resource('programs',    Admin\ProgramController::class)->except(['show']);
    Route::resource('categories',  Admin\ProgramCategoryController::class)->except(['show']);
    Route::resource('articles',    Admin\ArticleController::class)->except(['show']);
    Route::resource('partners',    Admin\PartnerController::class)->except(['show']);
    Route::resource('testimonials',Admin\TestimonialController::class)->except(['show']);
    Route::resource('users',       Admin\UserController::class)->except(['show']);

    // Inquiries
    Route::get('inquiries',                [Admin\InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('inquiries/export',         [Admin\InquiryController::class, 'export'])->name('inquiries.export');
    Route::get('inquiries/{inquiry}',      [Admin\InquiryController::class, 'show'])->name('inquiries.show');
    Route::put('inquiries/{inquiry}',      [Admin\InquiryController::class, 'update'])->name('inquiries.update');
    Route::delete('inquiries/{inquiry}',   [Admin\InquiryController::class, 'destroy'])->name('inquiries.destroy');

    // Messages
    Route::get('messages',           [Admin\ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [Admin\ContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('messages/{message}', [Admin\ContactMessageController::class, 'destroy'])->name('messages.destroy');

    // Pages (registry-based, slug-keyed)
    Route::get('pages',             [Admin\PageController::class, 'index'])->name('pages.index');
    Route::get('pages/{slug}/edit', [Admin\PageController::class, 'edit'])->name('pages.edit');
    Route::put('pages/{slug}',      [Admin\PageController::class, 'update'])->name('pages.update');

    // Settings
    Route::get('settings',  [Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [Admin\SettingController::class, 'update'])->name('settings.update');
});
