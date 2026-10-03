<?php

use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', [ToolController::class, 'home'])->name('home');

// All 17 Tools Routes
Route::prefix('tools')->name('tools.')->group(function () {
    Route::get('/json-formatter', fn() => app(ToolController::class)->show('json-formatter'))->name('json-formatter');
    Route::get('/json-validator', fn() => app(ToolController::class)->show('json-validator'))->name('json-validator');
    Route::get('/base64-encoder-decoder', fn() => app(ToolController::class)->show('base64-encoder-decoder'))->name('base64-encoder-decoder');
    Route::get('/url-encoder-decoder', fn() => app(ToolController::class)->show('url-encoder-decoder'))->name('url-encoder-decoder');
    Route::get('/uuid-generator', fn() => app(ToolController::class)->show('uuid-generator'))->name('uuid-generator');
    Route::get('/password-generator', fn() => app(ToolController::class)->show('password-generator'))->name('password-generator');
    Route::get('/qr-code-generator', fn() => app(ToolController::class)->show('qr-code-generator'))->name('qr-code-generator');
    Route::get('/slug-generator', fn() => app(ToolController::class)->show('slug-generator'))->name('slug-generator');
    Route::get('/jwt-decoder', fn() => app(ToolController::class)->show('jwt-decoder'))->name('jwt-decoder');
    Route::get('/unix-timestamp-converter', fn() => app(ToolController::class)->show('unix-timestamp-converter'))->name('unix-timestamp-converter');
    Route::get('/html-formatter', fn() => app(ToolController::class)->show('html-formatter'))->name('html-formatter');
    Route::get('/css-formatter', fn() => app(ToolController::class)->show('css-formatter'))->name('css-formatter');
    Route::get('/sql-formatter', fn() => app(ToolController::class)->show('sql-formatter'))->name('sql-formatter');
    Route::get('/image-compressor', fn() => app(ToolController::class)->show('image-compressor'))->name('image-compressor');
    Route::get('/word-counter', fn() => app(ToolController::class)->show('word-counter'))->name('word-counter');
    Route::get('/case-converter', fn() => app(ToolController::class)->show('case-converter'))->name('case-converter');
    Route::get('/color-converter', fn() => app(ToolController::class)->show('color-converter'))->name('color-converter');
});

// Sitemap
Route::get('/sitemap.xml', [ToolController::class, 'sitemap'])->name('sitemap');

