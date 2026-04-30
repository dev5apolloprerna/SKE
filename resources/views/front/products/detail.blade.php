@extends('layouts.front_app')
@section('title', ($product->seo_title ?? $product->name) . ' – Shree Kalika Enterprises')
@section('meta_desc', $product->seo_description ?? $product->short_description)

@section('content')
<div class="page-hero" style="padding:70px 0 50px;">
    <div class="container page-hero-content">
        <div class="breadcrumb-nav">
            <a href="{{ route('home') }}">Home</a><span class="sep">/</span>
            <a href="{{ route('products.index') }}">Products</a><span class="sep">/</span>
            <a href="{{ route('category.show', $product->category->slug) }}">{{ $product->category->name }}</a><span class="sep">/</span>
            @if($product->subcategory)
            <a href="{{ route('subcategory.show', [$product->category->slug, $product->subcategory->slug]) }}">{{ $product->subcategory->name }}</a><span class="sep">/</span>
            @endif
            <span>{{ $product->model_no }}</span>
        </div>
    </div>
</div>

{{-- PRODUCT DETAIL --}}
<section class="product-detail-section">
    <div class="container">
        <div class="row g-5 align-items-start">

            {{-- IMAGE GALLERY --}}
            <div class="col-lg-5" data-animate>
                <div class="product-gallery-wrap">
                    <div class="product-main-img">
                        <img id="mainProductImg"
                             src="{{ $product->primary_image }}"
                             alt="{{ $product->name }}"
                             onerror="this.src='{{ asset('images/default-product.jpg') }}'"/>
                    </div>

                    @if($product->images->count() > 1)
                    <div class="product-thumbs">
                        @foreach($product->images as $i => $img)
                        <div class="product-thumb-item {{ $i === 0 ? 'active' : '' }}"
                             data-src="{{ $img->url }}"
                             data-alt="{{ $img->alt_text ?? $product->name }}">
                            <img src="{{ $img->url }}"
                                 alt="{{ $img->alt_text ?? $product->name }}"
                                 onerror="this.src='{{ asset('images/default-product.jpg') }}'"/>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- PRODUCT INFO --}}
            <div class="col-lg-7" data-animate data-delay="2">
                <div class="product-info">

                    <div class="product-detail-cat">
                        <a href="{{ route('category.show', $product->category->slug) }}">{{ $product->category->name }}</a>
                        @if($product->subcategory)
                        <span>/</span>
                        <a href="{{ route('subcategory.show', [$product->category->slug, $product->subcategory->slug]) }}">{{ $product->subcategory->name }}</a>
                        @endif
                    </div>

                    <h1 class="product-detail-title">{{ $product->name }}</h1>
                    <div class="product-model-badge">Model: {{ $product->model_no }}</div>

                    @if($product->short_description)
                    <p class="product-short-desc">{{ $product->short_description }}</p>
                    @endif

                    {{-- SPECIFICATIONS TABLE --}}
                    <table class="product-specs-table">
                        <thead>
                            <tr><th colspan="2"><i class="fa-solid fa-list-check" style="margin-right:6px;"></i> Specifications</th></tr>
                        </thead>
                        <tbody>
                            @if($product->model_no)
                            <tr><td>Model No.</td><td>{{ $product->model_no }}</td></tr>
                            @endif
                            @if($product->length_mm)
                            <tr><td>Length</td><td>{{ (int)$product->length_mm }} mm</td></tr>
                            @endif
                            @if($product->width_mm)
                            <tr><td>Width</td><td>{{ (int)$product->width_mm }} mm</td></tr>
                            @endif
                            @if($product->height_mm)
                            <tr><td>Height / Depth</td><td>{{ (int)$product->height_mm }} mm</td></tr>
                            @endif
                            @if($product->length_mm && $product->width_mm && $product->height_mm)
                            <tr><td>Dimensions</td><td>{{ $product->dimensions }}</td></tr>
                            @endif
                            @if($product->specifications)
                                @foreach($product->specifications as $key => $val)
                                <tr><td>{{ $key }}</td><td>{{ $val }}</td></tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    {{-- DESCRIPTION --}}
                    @if($product->long_description)
                    <div style="margin-bottom:24px;">
                        <h4 style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:var(--navy);margin-bottom:10px;">Product Description</h4>
                        <p style="font-size:0.9rem;color:var(--text-mid);line-height:1.75;">{{ $product->long_description }}</p>
                    </div>
                    @endif

                    {{-- ACTION BUTTONS --}}
                    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:24px;">
                        <button class="btn-primary" data-bs-toggle="modal" data-bs-target="#inquiryModal">
                            <i class="fa-solid fa-paper-plane"></i> Send Enquiry
                        </button>
                        <a href="https://wa.me/917490806940?text=Hello%2C%20I%20am%20interested%20in%20{{ urlencode($product->name) }}%20({{ $product->model_no }}).%20Please%20share%20details." target="_blank" class="btn-outline" style="border-color:#25D366;color:#25D366;">
                            <i class="fa-brands fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="tel:+917490806940" class="btn-outline">
                            <i class="fa-solid fa-phone"></i> Call Now
                        </a>
                    </div>

                    {{-- TRUST BADGES --}}
                    <div style="display:flex;gap:16px;flex-wrap:wrap;padding:16px;background:var(--ivory);border-radius:var(--radius);border:1px solid var(--border);">
                        <div style="display:flex;align-items:center;gap:6px;font-size:0.78rem;font-weight:600;color:var(--text-mid);">
                            <i class="fa-solid fa-shield-halved" style="color:var(--gold);"></i> Quality Assured
                        </div>
                        <div style="display:flex;align-items:center;gap:6px;font-size:0.78rem;font-weight:600;color:var(--text-mid);">
                            <i class="fa-solid fa-truck-fast" style="color:var(--gold);"></i> Pan India Delivery
                        </div>
                        <div style="display:flex;align-items:center;gap:6px;font-size:0.78rem;font-weight:600;color:var(--text-mid);">
                            <i class="fa-solid fa-headset" style="color:var(--gold);"></i> Expert Support
                        </div>
                        <div style="display:flex;align-items:center;gap:6px;font-size:0.78rem;font-weight:600;color:var(--text-mid);">
                            <i class="fa-solid fa-award" style="color:var(--gold);"></i> ISO Certified
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- RELATED PRODUCTS --}}
@if($related->count())
<section class="related-section">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4" data-animate>
            <div>
                <span class="section-tag">You May Also Like</span>
                <h2 class="section-title related-section-title">Related <span>Products</span></h2>
                <div class="divider-gold"></div>
            </div>
            @if($product->subcategory)
            <a href="{{ route('subcategory.show', [$product->category->slug, $product->subcategory->slug]) }}" class="btn-outline">
                View All {{ $product->subcategory->name }} <i class="fa-solid fa-arrow-right"></i>
            </a>
            @endif
        </div>
        <div class="products-slider" style="grid-template-columns:repeat(auto-fill,minmax(220px,1fr));">
            @foreach($related as $rel)
            <a class="product-card" href="{{ route('product.show', $rel->slug) }}" data-animate>
                <div class="product-thumb">
                    <img src="{{ $rel->primary_image }}"
                         alt="{{ $rel->name }}"
                         loading="lazy"
                         onerror="this.src='{{ asset('images/default-product.jpg') }}'"/>
                </div>
                <div class="product-body">
                    <div class="product-category">{{ $product->subcategory->name ?? $product->category->name }}</div>
                    <div class="product-name">{{ $rel->name }}</div>
                    @if($rel->length_mm)
                    <div class="product-dims"><i class="fa-solid fa-ruler-combined"></i> {{ $rel->dimensions }}</div>
                    @endif
                    <div class="product-view-btn">View Details <i class="fa-solid fa-arrow-right"></i></div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- INQUIRY MODAL --}}
<div class="modal fade inquiry-modal" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inquiryModalLabel">
                    <i class="fa-solid fa-paper-plane" style="color:var(--gold);margin-right:8px;"></i>
                    Product Enquiry
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:24px;">
                <p style="font-size:0.85rem;color:var(--text-mid);margin-bottom:18px;">
                    Enquiring about: <strong>{{ $product->name }}</strong> ({{ $product->model_no }})
                </p>
                <div id="inquiryMsg"></div>
                <form id="inquiryForm" action="{{ route('inquiry.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}"/>
                    <div class="form-row" style="margin-bottom:14px;">
                        <div>
                            <label class="ske-form-label">Name <span style="color:var(--crimson);">*</span></label>
                            <input type="text" name="name" class="ske-form-control" placeholder="Your name" required/>
                        </div>
                        <div>
                            <label class="ske-form-label">Company</label>
                            <input type="text" name="company_name" class="ske-form-control" placeholder="Company name"/>
                        </div>
                    </div>
                    <div class="form-row" style="margin-bottom:14px;">
                        <div>
                            <label class="ske-form-label">Phone <span style="color:var(--crimson);">*</span></label>
                            <input type="tel" name="phone" class="ske-form-control" placeholder="+91 XXXXX XXXXX" required/>
                        </div>
                        <div>
                            <label class="ske-form-label">Quantity</label>
                            <input type="text" name="quantity" class="ske-form-control" placeholder="e.g. 100 pcs"/>
                        </div>
                    </div>
                    <div style="margin-bottom:16px;">
                        <label class="ske-form-label">Message</label>
                        <textarea name="message" class="ske-form-control" rows="3" placeholder="Any specific requirements?"></textarea>
                    </div>
                    <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">
                        <i class="fa-solid fa-paper-plane"></i> Send Enquiry
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.related-section-title { font-size: 1.7rem !important; }
</style>
@endpush
