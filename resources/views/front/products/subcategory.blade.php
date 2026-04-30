@extends('layouts.front_app')
@section('title', $subcategory->name . ' – ' . $category->name . ' – Shree Kalika Enterprises')
@section('meta_desc', 'Browse ' . $subcategory->name . ' from Shree Kalika Enterprises – quality industrial storage products.')

@section('content')
<div class="page-hero">
    <div class="container page-hero-content">
        <div class="breadcrumb-nav">
            <a href="{{ route('home') }}">Home</a><span class="sep">/</span>
            <a href="{{ route('products.index') }}">Products</a><span class="sep">/</span>
            <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a><span class="sep">/</span>
            <span>{{ $subcategory->name }}</span>
        </div>
        <h1 class="page-title">{{ $subcategory->name }}</h1>
        <p class="page-subtitle">{{ $category->name }} › {{ $subcategory->name }}</p>
    </div>
</div>

<section class="listing-section">
    <div class="container">
        <div class="row g-4">

            {{-- SIDEBAR --}}
            <div class="col-lg-3">
                <div class="filter-sidebar" data-animate>
                    <div class="filter-title"><i class="fa-solid fa-layer-group"></i> {{ $category->name }}</div>
                    <a href="{{ route('category.show', $category->slug) }}" class="subcategory-filter-link">
                        <i class="fa-solid fa-grid-2"></i> All {{ $category->name }}
                    </a>
                    @foreach($category->subcategories as $sub)
                    <a href="{{ route('subcategory.show', [$category->slug, $sub->slug]) }}"
                       class="subcategory-filter-link {{ $sub->id == $subcategory->id ? 'active' : '' }}">
                        <i class="fa-solid fa-angle-right"></i> {{ $sub->name }}
                    </a>
                    @endforeach

                    <div style="margin-top:24px;padding-top:20px;border-top:1px solid var(--border);">
                        <div class="filter-title"><i class="fa-solid fa-boxes-stacking"></i> All Categories</div>
                        @foreach($categories as $cat)
                        <a href="{{ route('category.show', $cat->slug) }}"
                           class="subcategory-filter-link {{ $cat->id == $category->id ? 'active' : '' }}">
                            <i class="fa-solid fa-box"></i> {{ $cat->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- PRODUCTS --}}
            <div class="col-lg-9">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2" data-animate>
                    <p class="result-count">
                        <strong>{{ $subcategory->name }}</strong> — {{ $products->total() }} products
                    </p>
                </div>

                @if($products->count())
                <div class="listing-grid">
                    @foreach($products as $product)
                    <a class="product-card" href="{{ route('product.show', $product->slug) }}" data-animate>
                        <div class="product-thumb">
                            @if($product->is_featured)<div class="product-tag">Featured</div>@endif
                            <img src="{{ $product->primary_image }}"
                                 alt="{{ $product->name }}"
                                 loading="lazy"
                                 onerror="this.src='{{ asset('images/default-product.jpg') }}'"/>
                        </div>
                        <div class="product-body">
                            <div class="product-category">{{ $subcategory->name }}</div>
                            <div class="product-name">{{ $product->name }}</div>
                            @if($product->length_mm)
                            <div class="product-dims"><i class="fa-solid fa-ruler-combined"></i> {{ $product->dimensions }}</div>
                            @endif
                            <div class="product-view-btn">View Details <i class="fa-solid fa-arrow-right"></i></div>
                        </div>
                    </a>
                    @endforeach
                </div>

                @if($products->hasPages())
                <div class="ske-pagination">
                    @if($products->onFirstPage())
                        <span><i class="fa-solid fa-chevron-left"></i></span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}"><i class="fa-solid fa-chevron-left"></i></a>
                    @endif
                    @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if($page == $products->currentPage())
                            <span class="active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                    @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}"><i class="fa-solid fa-chevron-right"></i></a>
                    @else
                        <span><i class="fa-solid fa-chevron-right"></i></span>
                    @endif
                </div>
                @endif

                @else
                <div style="text-align:center;padding:60px 0;">
                    <i class="fa-solid fa-box-open" style="font-size:3rem;color:var(--border);margin-bottom:16px;display:block;"></i>
                    <p style="color:var(--text-mid);">No products found in this sub-category yet.</p>
                    <a href="{{ route('category.show', $category->slug) }}" class="btn-outline" style="margin-top:16px;">Back to {{ $category->name }}</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
