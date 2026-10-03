@props(['tool', 'related' => []])

@extends('layouts.app')

@section('title', $tool['name'] . ' - Free Online Tool | Faruk Tools')
@section('meta_description', $tool['description'] . ' Fast, simple and privacy-friendly developer utility by Faruk Tools.')

@push('schema')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebApplication',
    'name' => $tool['name'],
    'url' => url()->current(),
    'description' => $tool['description'],
    'applicationCategory' => 'DeveloperApplication',
    'operatingSystem' => 'All',
    'browserRequirements' => 'Requires JavaScript. Requires HTML5.',
    'offers' => [
        '@type' => 'Offer',
        'price' => '0',
        'priceCurrency' => 'USD',
    ],
    'author' => [
        '@type' => 'Person',
        'name' => 'Md. Faruk Hossain',
        'url' => 'https://faruk.stsoft.top',
    ],
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => route('home'),
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Tools',
            'item' => route('home') . '#tools',
        ],
        [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $tool['name'],
            'item' => url()->current(),
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')
<div class="container tool-page-wrapper">
    <!-- Breadcrumb -->
    <nav class="breadcrumbs" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="bc-sep">/</span>
        <a href="{{ route('home') }}#tools">Tools</a>
        <span class="bc-sep">/</span>
        <span class="bc-current">{{ $tool['name'] }}</span>
    </nav>

    <!-- Tool Header -->
    <div class="tool-header">
        <div class="tool-header-top">
            <h1 class="tool-headline">{{ $tool['name'] }}</h1>
            <div class="tool-meta-tags">
                <span class="tool-badge">{{ $tool['category'] }}</span>
                <span class="privacy-pill">
                    <span class="privacy-dot"></span>
                    {{ $tool['privacy'] ?? 'Local only' }}
                </span>
            </div>
        </div>
        <p class="tool-lead">{{ $tool['description'] }}</p>
    </div>

    <!-- Main Tool Workspace -->
    <div class="tool-workspace">
        {{ $slot }}
    </div>

    <!-- Related Tools Section -->
    @if(!empty($related) && count($related) > 0)
        <div style="margin-top: 3.5rem;">
            <div class="section-header" style="margin-bottom: 1rem;">
                <h2 class="section-title" style="font-size: 1.15rem; font-weight: 600;">Related Tools</h2>
            </div>
            <div class="tools-grid" style="margin-bottom: 0;">
                @foreach($related as $relTool)
                    <x-tool-card :tool="$relTool" />
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
