<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ToolController extends Controller
{
    /**
     * Get all available tools and their metadata.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function getTools(): array
    {
        return [
            'json-formatter' => [
                'slug' => 'json-formatter',
                'name' => 'JSON Formatter',
                'category' => 'Formatters',
                'categories' => ['Formatters', 'Developer Tools'],
                'description' => 'Format, validate, and minify JSON data.',
                'icon' => 'brackets-curly',
                'route' => 'tools.json-formatter',
                'path' => '/tools/json-formatter',
                'privacy' => 'Local only',
            ],
            'json-validator' => [
                'slug' => 'json-validator',
                'name' => 'JSON Validator',
                'category' => 'Developer Tools',
                'categories' => ['Developer Tools', 'Formatters'],
                'description' => 'Validate JSON syntax and inspect parse errors.',
                'icon' => 'check-circle',
                'route' => 'tools.json-validator',
                'path' => '/tools/json-validator',
                'privacy' => 'Local only',
            ],
            'base64-encoder-decoder' => [
                'slug' => 'base64-encoder-decoder',
                'name' => 'Base64 Encoder / Decoder',
                'category' => 'Converters',
                'categories' => ['Converters', 'Developer Tools'],
                'description' => 'Encode and decode Base64 strings with UTF-8 support.',
                'icon' => 'code-brackets',
                'route' => 'tools.base64-encoder-decoder',
                'path' => '/tools/base64-encoder-decoder',
                'privacy' => 'Local only',
            ],
            'url-encoder-decoder' => [
                'slug' => 'url-encoder-decoder',
                'name' => 'URL Encoder / Decoder',
                'category' => 'Converters',
                'categories' => ['Converters', 'Developer Tools'],
                'description' => 'Encode and decode URLs and URI query parameters.',
                'icon' => 'link',
                'route' => 'tools.url-encoder-decoder',
                'path' => '/tools/url-encoder-decoder',
                'privacy' => 'Local only',
            ],
            'uuid-generator' => [
                'slug' => 'uuid-generator',
                'name' => 'UUID Generator',
                'category' => 'Generators',
                'categories' => ['Generators', 'Developer Tools'],
                'description' => 'Generate cryptographically secure Version 4 UUIDs.',
                'icon' => 'fingerprint',
                'route' => 'tools.uuid-generator',
                'path' => '/tools/uuid-generator',
                'privacy' => 'Web Crypto',
            ],
            'password-generator' => [
                'slug' => 'password-generator',
                'name' => 'Password Generator',
                'category' => 'Generators',
                'categories' => ['Generators', 'Developer Tools'],
                'description' => 'Create strong, random passwords client-side.',
                'icon' => 'key',
                'route' => 'tools.password-generator',
                'path' => '/tools/password-generator',
                'privacy' => 'Local only',
            ],
            'qr-code-generator' => [
                'slug' => 'qr-code-generator',
                'name' => 'QR Code Generator',
                'category' => 'Generators',
                'categories' => ['Generators', 'Image Tools'],
                'description' => 'Generate high-res QR codes and download as PNG.',
                'icon' => 'qr-code',
                'route' => 'tools.qr-code-generator',
                'path' => '/tools/qr-code-generator',
                'privacy' => 'Canvas API',
            ],
            'slug-generator' => [
                'slug' => 'slug-generator',
                'name' => 'Slug Generator',
                'category' => 'Generators',
                'categories' => ['Generators', 'Text Tools'],
                'description' => 'Convert text to clean URL slugs (English & বাংলা).',
                'icon' => 'text-cursor',
                'route' => 'tools.slug-generator',
                'path' => '/tools/slug-generator',
                'privacy' => 'Local only',
            ],
            'jwt-decoder' => [
                'slug' => 'jwt-decoder',
                'name' => 'JWT Decoder',
                'category' => 'Developer Tools',
                'categories' => ['Developer Tools', 'Converters'],
                'description' => 'Decode and inspect JWT headers, payloads, and expiry.',
                'icon' => 'shield-check',
                'route' => 'tools.jwt-decoder',
                'path' => '/tools/jwt-decoder',
                'privacy' => 'Local only',
            ],
            'unix-timestamp-converter' => [
                'slug' => 'unix-timestamp-converter',
                'name' => 'Unix Timestamp Converter',
                'category' => 'Converters',
                'categories' => ['Converters', 'Developer Tools'],
                'description' => 'Convert timestamps to human dates and vice-versa.',
                'icon' => 'clock',
                'route' => 'tools.unix-timestamp-converter',
                'path' => '/tools/unix-timestamp-converter',
                'privacy' => 'Local only',
            ],
            'html-formatter' => [
                'slug' => 'html-formatter',
                'name' => 'HTML Formatter',
                'category' => 'Formatters',
                'categories' => ['Formatters', 'Developer Tools'],
                'description' => 'Format and minify HTML code with clean indentation.',
                'icon' => 'file-code',
                'route' => 'tools.html-formatter',
                'path' => '/tools/html-formatter',
                'privacy' => 'Local only',
            ],
            'css-formatter' => [
                'slug' => 'css-formatter',
                'name' => 'CSS Formatter',
                'category' => 'Formatters',
                'categories' => ['Formatters', 'Developer Tools'],
                'description' => 'Beautify or minify CSS stylesheets.',
                'icon' => 'palette',
                'route' => 'tools.css-formatter',
                'path' => '/tools/css-formatter',
                'privacy' => 'Local only',
            ],
            'sql-formatter' => [
                'slug' => 'sql-formatter',
                'name' => 'SQL Formatter',
                'category' => 'Formatters',
                'categories' => ['Formatters', 'Developer Tools'],
                'description' => 'Format SQL queries with structured indentation.',
                'icon' => 'database',
                'route' => 'tools.sql-formatter',
                'path' => '/tools/sql-formatter',
                'privacy' => 'Local only',
            ],
            'image-compressor' => [
                'slug' => 'image-compressor',
                'name' => 'Image Compressor',
                'category' => 'Image Tools',
                'categories' => ['Image Tools'],
                'description' => 'Compress images directly in your browser without upload.',
                'icon' => 'photo',
                'route' => 'tools.image-compressor',
                'path' => '/tools/image-compressor',
                'privacy' => 'Zero upload',
            ],
            'word-counter' => [
                'slug' => 'word-counter',
                'name' => 'Word Counter',
                'category' => 'Text Tools',
                'categories' => ['Text Tools'],
                'description' => 'Live count of words, characters, sentences, and reading time.',
                'icon' => 'document-text',
                'route' => 'tools.word-counter',
                'path' => '/tools/word-counter',
                'privacy' => 'Local only',
            ],
            'case-converter' => [
                'slug' => 'case-converter',
                'name' => 'Case Converter',
                'category' => 'Text Tools',
                'categories' => ['Text Tools'],
                'description' => 'Convert text to UPPERCASE, lowercase, camelCase, etc.',
                'icon' => 'switch-horizontal',
                'route' => 'tools.case-converter',
                'path' => '/tools/case-converter',
                'privacy' => 'Local only',
            ],
            'color-converter' => [
                'slug' => 'color-converter',
                'name' => 'Color Converter',
                'category' => 'Converters',
                'categories' => ['Converters', 'Developer Tools'],
                'description' => 'Convert and preview HEX, RGB, HSL, RGBA, and HSLA.',
                'icon' => 'color-swatch',
                'route' => 'tools.color-converter',
                'path' => '/tools/color-converter',
                'privacy' => 'Local only',
            ],
        ];
    }

    /**
     * Categories list.
     *
     * @return array<string>
     */
    public static function getCategories(): array
    {
        return [
            'Developer Tools',
            'Converters',
            'Generators',
            'Formatters',
            'Text Tools',
            'Image Tools',
        ];
    }

    /**
     * Display the homepage.
     */
    public function home(): View
    {
        $tools = self::getTools();
        $categories = self::getCategories();

        return view('home', compact('tools', 'categories'));
    }

    /**
     * Show a tool by slug.
     */
    public function show(string $slug): View
    {
        $tools = self::getTools();

        if (!array_key_exists($slug, $tools)) {
            abort(404, 'Tool not found');
        }

        $tool = $tools[$slug];
        
        // Find related tools in same category
        $related = array_filter($tools, function ($item) use ($tool, $slug) {
            return $item['slug'] !== $slug && (
                $item['category'] === $tool['category'] || 
                count(array_intersect($item['categories'], $tool['categories'])) > 0
            );
        });

        $related = array_slice($related, 0, 3);

        return view('tools.' . $slug, compact('tool', 'related'));
    }

    /**
     * Generate dynamic sitemap XML.
     */
    public function sitemap(): \Illuminate\Http\Response
    {
        $tools = self::getTools();
        $baseUrl = rtrim(config('app.url', 'https://tools.faruk.stsoft.top'), '/');

        return response()->view('sitemap', compact('tools', 'baseUrl'))
            ->header('Content-Type', 'text/xml');
    }
}
