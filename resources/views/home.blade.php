@extends('layouts.app')

@section('title', 'Faruk Tools - Free Developer Tools for Everyone')
@section('meta_description', 'Fast, simple and privacy-friendly online tools for developers, designers and web professionals.')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <section class="hero">
        <h1 class="hero-title">Free Developer Tools for Everyone</h1>
        <p class="hero-subtitle">Fast, simple and privacy-friendly online tools for developers, designers and web professionals.</p>

        <!-- Search Bar -->
        <div class="search-wrapper">
            <div class="search-input-group">
                <span class="search-icon">
                    <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input 
                    type="text" 
                    id="tool-search-input" 
                    class="search-input" 
                    placeholder="Search tools... (JSON, UUID, Base64, JWT, Image)" 
                    autocomplete="off"
                    aria-label="Search tools"
                >
                <button type="button" id="search-clear-btn" class="search-clear" aria-label="Clear search">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Categories Filter -->
        <div class="categories-nav" id="categories">
            <button type="button" class="cat-btn active" data-category="all">All ({{ count($tools) }})</button>
            @foreach($categories as $category)
                <button type="button" class="cat-btn" data-category="{{ $category }}">{{ $category }}</button>
            @endforeach
        </div>
    </section>

    <!-- Tools Listing Section -->
    <section id="tools">
        <div class="section-header">
            <h2 class="section-title">All Utilities</h2>
            <span class="tool-count" id="visible-tool-count">{{ count($tools) }} tools</span>
        </div>

        <div class="tools-grid" id="tools-grid">
            @foreach($tools as $tool)
                <x-tool-card :tool="$tool" />
            @endforeach
        </div>

        <div id="no-tools-found" style="display: none; text-align: center; padding: 4rem 1rem;">
            <p style="font-size: 1rem; color: var(--text-muted); margin-bottom: 0.25rem;">No tools match your query.</p>
            <p style="font-size: 0.85rem; color: var(--text-subtle);">Try a different keyword or reset filters.</p>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section" id="about">
        <div class="about-card">
            <div class="about-content">
                <h2 class="about-title">About Faruk Tools</h2>
                <p class="about-lead">
                    Faruk Tools is a collection of free browser-based utilities for developers, designers and web professionals. Many tools process data directly in the browser without sending it to a server.
                </p>
                <div class="about-meta">
                    <span>Created by <strong>Md. Faruk Hossain</strong></span>
                    <span class="meta-dot">&bull;</span>
                    <span>PHP Laravel Developer &bull; Bangladesh</span>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
