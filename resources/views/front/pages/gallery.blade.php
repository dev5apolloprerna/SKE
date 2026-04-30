@extends('layouts.front_app')
@section('title','Gallery – Shree Kalika Enterprises')
@section('meta_desc','Browse our product gallery – plastic crates, storage bins, pallets, shelving systems, and more.')

@section('content')
<div class="page-hero">
    <div class="container page-hero-content">
        <div class="breadcrumb-nav">
            <a href="{{ route('home') }}">Home</a><span class="sep">/</span><span>Gallery</span>
        </div>
        <h1 class="page-title">Product <span>Gallery</span></h1>
        <p class="page-subtitle">Explore our range of industrial storage and handling solutions. Click any image for a full view.</p>
    </div>
</div>

<section class="gallery-section">
    <div class="container">
        @if($images->count())
        <div class="gallery-grid">
            @foreach($images as $img)
            <div class="gallery-item"
                 data-full="{{ $img->url }}"
                 data-caption="{{ $img->title }}"
                 data-animate>
                <img src="{{ $img->url }}"
                     alt="{{ $img->title }}"
                     loading="lazy"
                     onerror="this.src='{{ asset('images/default-product.jpg') }}'"/>
                <div class="gallery-overlay">
                    <div class="gallery-overlay-icon"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                    <span class="gallery-caption">{{ $img->title }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align:center;padding:80px 0;">
            <i class="fa-solid fa-images" style="font-size:3rem;color:var(--border);margin-bottom:16px;display:block;"></i>
            <p style="color:var(--text-mid);">Gallery images coming soon. Check back later!</p>
        </div>
        @endif
    </div>
</section>

{{-- LIGHTBOX --}}
<div class="ske-lightbox" id="skeLightbox">
    <div class="lightbox-inner">
        <button class="lightbox-close" id="lightboxClose"><i class="fa-solid fa-xmark"></i></button>
        <button class="lightbox-prev" id="lightboxPrev"><i class="fa-solid fa-chevron-left"></i></button>
        <img class="lightbox-img" id="lightboxImg" src="" alt=""/>
        <button class="lightbox-next" id="lightboxNext"><i class="fa-solid fa-chevron-right"></i></button>
        <div class="lightbox-caption" id="lightboxCaption"></div>
    </div>
</div>

<section class="cta-section">
    <div class="container">
        <div class="cta-inner" data-animate>
            <span class="section-tag" style="color:var(--gold-light);">Interested in Our Products?</span>
            <h2 class="section-title" style="color:var(--white);">Let's Discuss Your <span>Requirements</span></h2>
            <p>Contact us today to get a quote or request a detailed product catalog.</p>
            <div class="cta-actions">
                <a href="{{ route('contact') }}" class="btn-white"><i class="fa-solid fa-envelope"></i> Get in Touch</a>
                <a href="{{ route('products.index') }}" class="btn-outline" style="border-color:rgba(255,255,255,0.5);color:var(--white);"><i class="fa-solid fa-box"></i> Browse Products</a>
            </div>
        </div>
    </div>
</section>
@endsection
