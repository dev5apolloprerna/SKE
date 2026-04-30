@extends('layouts.front_app')
@section('title','All Products – Shree Kalika Enterprises')
@section('meta_desc','Browse all industrial storage products from Shree Kalika Enterprises – crates, bins, pallets, racks, and more.')

@section('content')
<div class="page-hero">
    <div class="container page-hero-content">
        <div class="breadcrumb-nav">
            <a href="{{ route('home') }}">Home</a><span class="sep">/</span><span>Products</span>
        </div>
        <h1 class="page-title">Our <span>Products</span></h1>
        <p class="page-subtitle">Explore our comprehensive range of industrial storage and material handling solutions.</p>
    </div>
</div>

<section class="listing-section">
    <div class="container">
        <div class="row g-4">

            {{-- SIDEBAR --}}
            <div class="col-lg-3">
                <div class="filter-sidebar" data-animate>
                    <div class="filter-title"><i class="fa-solid fa-filter"></i> Categories</div>
                    <div class="filter-group">
                        @foreach($categories as $cat)
                        <div style="margin-bottom:4px;">
                            <a href="{{ route('category.show', $cat->slug) }}"
                               class="subcategory-filter-link">
                                <i class="fa-solid fa-box"></i> {{ $cat->name }}
                            </a>
                            @foreach($cat->subcategories as $sub)
                            <a href="{{ route('subcategory.show', [$cat->slug, $sub->slug]) }}"
                               class="subcategory-filter-link"
                               style="padding-left:24px;font-size:0.8rem;">
                                <i class="fa-solid fa-angle-right"></i> {{ $sub->name }}
                            </a>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- PRODUCTS --}}
            <div class="col-lg-9">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2" data-animate>
                    <p class="result-count">Showing <strong>{{ $products->firstItem() }}–{{ $products->lastItem() }}</strong> of <strong>{{ $products->total() }}</strong> products</p>
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
                            <div class="product-category">{{ $product->category->name }}</div>
                            <div class="product-name">{{ $product->name }}</div>
                            @if($product->length_mm)
                            <div class="product-dims"><i class="fa-solid fa-ruler-combined"></i> {{ $product->dimensions }}</div>
                            @endif
                            <div class="product-view-btn">View Details <i class="fa-solid fa-arrow-right"></i></div>
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- PAGINATION --}}
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
                    <p style="color:var(--text-mid);">No products found. Please check back soon.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
