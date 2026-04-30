@extends('layouts.front_app')
@section('title','About Us – Shree Kalika Enterprises')
@section('meta_desc','Learn about Shree Kalika Enterprises – ISO 9001:2015 certified supplier of industrial storage products.')

@section('content')
<div class="page-hero">
    <div class="container page-hero-content">
        <div class="breadcrumb-nav">
            <a href="{{ route('home') }}">Home</a>
            <span class="sep">/</span>
            <span>About Us</span>
        </div>
        <h1 class="page-title">About <span>Shree Kalika</span><br/>Enterprises</h1>
        <p class="page-subtitle">ISO 9001:2015 certified supplier of industrial storage and material handling solutions since 2020.</p>
    </div>
</div>

{{-- OUR STORY --}}
<section class="about-page">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5" data-animate>
                <div style="aspect-ratio:4/3;border-radius:var(--radius-lg);overflow:hidden;background:var(--navy);box-shadow:var(--shadow-lg);display:flex;align-items:center;justify-content:center;">
                    <img src="{{ asset('images/logo.png') }}" alt="SKE" style="width:100%;height:100%;object-fit:contain;padding:40px;"/>
                </div>
            </div>
            <div class="col-lg-7" data-animate data-delay="2">
                <span class="section-tag">Our Story</span>
                <h2 class="section-title">Built on Trust, <span>Driven by Quality</span></h2>
                <div class="divider-gold"></div>
                <p style="color:var(--text-mid);line-height:1.8;margin-bottom:16px;">
                    Founded in 2020 by <strong>Mr. Mayur Prajapati</strong>, Shree Kalika Enterprises set out with a clear mission: to provide businesses across Gujarat and India with high-quality industrial storage and material handling products at competitive prices.
                </p>
                <p style="color:var(--text-mid);line-height:1.8;margin-bottom:16px;">
                    In just four years, we have grown from a small local supplier into a trusted name serving manufacturing plants, warehouses, pharmaceutical companies, agricultural businesses, and retail chains across the country.
                </p>
                <p style="color:var(--text-mid);line-height:1.8;">
                    Our product range spans over 500 SKUs across 8 categories — from compact FPO storage bins to large-scale pallet racking systems — all sourced from quality-certified manufacturers who share our commitment to excellence.
                </p>
                <div style="margin-top:28px;display:flex;gap:14px;flex-wrap:wrap;">
                    <a href="{{ route('products.index') }}" class="btn-primary">View Products <i class="fa-solid fa-arrow-right"></i></a>
                    <a href="{{ route('contact') }}" class="btn-outline">Get In Touch</a>
                </div>
            </div>
        </div>

        {{-- STATS --}}
        <div class="about-stat-grid">
            <div class="stat-box" data-animate>
                <div class="stat-num">500+</div>
                <div class="stat-lbl">Products</div>
            </div>
            <div class="stat-box" data-animate data-delay="1">
                <div class="stat-num">8</div>
                <div class="stat-lbl">Categories</div>
            </div>
            <div class="stat-box" data-animate data-delay="2">
                <div class="stat-num">12+</div>
                <div class="stat-lbl">Industries Served</div>
            </div>
            <div class="stat-box" data-animate data-delay="3">
                <div class="stat-num">4+</div>
                <div class="stat-lbl">Years of Excellence</div>
            </div>
        </div>

        {{-- FEATURES --}}
        <div class="row g-4 mt-2">
            @foreach([
                ['check-circle','Wide Product Portfolio','Plastic crates, bins, pallets, racks, trolleys, dustbins and more — everything under one roof.'],
                ['shield-halved','Quality Assurance','Every product is evaluated for strength, finish, and functionality before we recommend it.'],
                ['truck-fast','Timely Delivery','Reliable logistics network ensures your orders arrive on time, every time.'],
                ['headset','Expert Support','Our team understands your industry and recommends the most suitable products for your needs.'],
            ] as [$icon, $title, $desc])
            <div class="col-md-6" data-animate>
                <div class="about-feat">
                    <i class="fa-solid fa-{{ $icon }}"></i>
                    <div class="about-feat-text">
                        <strong>{{ $title }}</strong>
                        <span>{{ $desc }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- MISSION / VISION / VALUES --}}
<section class="vision-section">
    <div class="container">
        <div class="section-header" data-animate>
            <span class="section-tag" style="color:var(--gold-light);">Our Foundation</span>
            <h2 class="section-title" style="color:var(--white);">Mission, Vision & <span>Values</span></h2>
            <div class="divider-gold"></div>
        </div>
        <div class="vision-grid">
            <div class="vision-card" data-animate>
                <div class="vision-icon"><i class="fa-solid fa-bullseye"></i></div>
                <div class="vision-title">Our Mission</div>
                <p class="vision-text">To deliver value-for-money industrial storage solutions that help businesses optimise their operations — combining quality, durability, and affordability in every product.</p>
            </div>
            <div class="vision-card" data-animate data-delay="2">
                <div class="vision-icon"><i class="fa-solid fa-eye"></i></div>
                <div class="vision-title">Our Vision</div>
                <p class="vision-text">To become the most trusted and preferred supplier of industrial storage and material handling products across India, recognised for quality, innovation, and exceptional service.</p>
            </div>
            <div class="vision-card" data-animate data-delay="3">
                <div class="vision-icon"><i class="fa-solid fa-handshake"></i></div>
                <div class="vision-title">Our Values</div>
                <p class="vision-text">Integrity in every transaction, commitment to quality in every product, and dedication to building long-term relationships with every customer we serve.</p>
            </div>
        </div>
    </div>
</section>

{{-- TEAM --}}
<section class="team-section">
    <div class="container">
        <div class="section-header" data-animate>
            <span class="section-tag">Leadership</span>
            <h2 class="section-title">Meet Our <span>Founder</span></h2>
            <div class="divider-gold"></div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-sm-10 col-md-6 col-lg-4" data-animate>
                <div class="team-card">
                    <div class="team-avatar">M</div>
                    <div class="team-name">Mr. Mayur Prajapati</div>
                    <div class="team-role">Founder & Director</div>
                    <p class="team-bio">With a deep understanding of industrial storage needs across sectors, Mr. Mayur Prajapati founded Shree Kalika Enterprises to bridge the gap between quality products and accessible pricing for businesses across India.</p>
                    <div style="margin-top:20px;display:flex;justify-content:center;gap:12px;flex-wrap:wrap;">
                        <a href="tel:+917490806940" class="btn-primary" style="padding:10px 20px;font-size:0.82rem;"><i class="fa-solid fa-phone"></i> Call Now</a>
                        <a href="https://wa.me/917490806940" target="_blank" class="btn-outline" style="padding:10px 20px;font-size:0.82rem;"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-inner" data-animate>
            <span class="section-tag" style="color:var(--gold-light);">Work With Us</span>
            <h2 class="section-title" style="color:var(--white);">Ready to Partner with <span>Shree Kalika</span>?</h2>
            <p>Get in touch today and discover how we can help optimise your storage and handling operations.</p>
            <div class="cta-actions">
                <a href="{{ route('contact') }}" class="btn-white"><i class="fa-solid fa-envelope"></i> Contact Us</a>
                <a href="{{ route('products.index') }}" class="btn-outline" style="border-color:rgba(255,255,255,0.5);color:var(--white);"><i class="fa-solid fa-box"></i> Browse Products</a>
            </div>
        </div>
    </div>
</section>
@endsection
