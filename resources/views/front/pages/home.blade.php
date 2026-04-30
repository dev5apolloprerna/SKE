@extends('layouts.front_app')

@section('title', 'Shree Kalika Enterprises – Industrial Storage & Material Handling Solutions')

@section('content')

{{-- HERO --}}
<section class="hero" id="home">
    <div class="hero-bg"></div>
    <div class="hero-pattern"></div>
    <div class="hero-circle"></div>
    <div class="hero-image-wrap">
        <img src="{{ asset('images/logo.png') }}" alt="Shree Kalika Enterprises"/>
    </div>
    <div class="container">
        <div class="hero-content" data-animate>
            <div class="hero-badge">
                <i class="fa-solid fa-certificate"></i>
                <span>ISO 9001:2015 Certified · Est. 2020</span>
            </div>
            <h1 class="hero-title">
                Industrial Storage &<br/>
                <span class="highlight">Material Handling</span><br/>Solutions
            </h1>
            <p class="hero-desc">Trusted supplier of plastic crates, storage bins, industrial pallets, shelving systems, and warehouse handling equipment across Gujarat & India.</p>
            <div class="hero-actions">
                <a href="{{ route('products.index') }}" class="btn-primary">Explore Products <i class="fa-solid fa-arrow-right"></i></a>
                <a href="{{ route('contact') }}" class="btn-outline"><i class="fa-solid fa-phone"></i> Get Quote</a>
            </div>
            <div class="hero-stats">
                <div><div class="hero-stat-num"><span data-counter data-target="500" data-suffix="+">500+</span></div><div class="hero-stat-label">Products</div></div>
                <div><div class="hero-stat-num"><span data-counter data-target="12" data-suffix="+">12+</span></div><div class="hero-stat-label">Industries Served</div></div>
                <div><div class="hero-stat-num"><span data-counter data-target="4" data-suffix="">4</span></div><div class="hero-stat-label">Years Strong</div></div>
                <div><div class="hero-stat-num"><span data-counter data-target="100" data-suffix="%">100%</span></div><div class="hero-stat-label">Customer Focus</div></div>
            </div>
        </div>
    </div>
    <div class="hero-scroll"><span>Scroll</span><div class="scroll-line"></div></div>
</section>

{{-- TRUST STRIP --}}
<div class="about-strip">
    <div class="container">
        <div class="strip-item"><i class="fa-solid fa-award"></i><span>ISO 9001:2015 Certified</span></div>
        <div class="strip-item"><i class="fa-solid fa-truck-fast"></i><span>Pan India Delivery</span></div>
        <div class="strip-item"><i class="fa-solid fa-headset"></i><span>Dedicated Support</span></div>
        <div class="strip-item"><i class="fa-solid fa-coins"></i><span>Competitive Pricing</span></div>
        <div class="strip-item"><i class="fa-solid fa-shield-halved"></i><span>Quality Guaranteed</span></div>
    </div>
</div>

{{-- ABOUT --}}
<section class="about-section" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-image-wrap" data-animate>
                <div class="about-image-main">
                    <img src="{{ asset('images/logo.png') }}" alt="Shree Kalika Enterprises"/>
                </div>
                <div class="about-badge-float"><div class="num">4+</div><div class="lbl">Years of<br/>Excellence</div></div>
            </div>
            <div class="about-content" data-animate data-delay="2">
                <span class="section-tag">About Us</span>
                <h2 class="section-title">Your Trusted Partner in <span>Industrial Solutions</span></h2>
                <div class="divider-gold"></div>
                <p class="section-sub">Founded in 2020 and led by <strong>Mr. Mayur Prajapati</strong>, Shree Kalika Enterprises is a rapidly growing name in industrial storage and material handling across Gujarat and India.</p>
                <div class="about-features">
                    <div class="about-feat"><i class="fa-solid fa-check-circle"></i><div class="about-feat-text"><strong>Wide Product Portfolio</strong><span>Plastic crates, bins, pallets, racks, trolleys, dustbins and more</span></div></div>
                    <div class="about-feat"><i class="fa-solid fa-check-circle"></i><div class="about-feat-text"><strong>Quality Assurance</strong><span>All products meet strength, finish and functionality benchmarks</span></div></div>
                    <div class="about-feat"><i class="fa-solid fa-check-circle"></i><div class="about-feat-text"><strong>Customer-First Approach</strong><span>Consultative recommendations tailored to your industry needs</span></div></div>
                    <div class="about-feat"><i class="fa-solid fa-check-circle"></i><div class="about-feat-text"><strong>Timely Delivery</strong><span>Reliable logistics to keep your operations running smoothly</span></div></div>
                </div>
                <div style="margin-top:30px;"><a href="{{ route('about') }}" class="btn-primary">Our Story <i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
        </div>
    </div>
</section>

{{-- CATEGORIES --}}
<section class="categories-section" id="categories">
    <div class="container">
        <div class="section-header" data-animate>
            <span class="section-tag">Product Range</span>
            <h2 class="section-title">Explore Our <span>Categories</span></h2>
            <div class="divider-gold"></div>
            <p class="section-sub" style="color:rgba(255,255,255,0.55);">From compact storage bins to heavy-duty pallets – browse our complete industrial range.</p>
        </div>
        <div class="categories-grid">
            @foreach($categories as $cat)
            <a class="cat-card" href="{{ route('category.show', $cat->slug) }}" data-animate>
                <div class="cat-card-image">
                    <img src="{{ $cat->image }}" alt="{{ $cat->name }}" onerror="this.src='{{ asset('images/default-category.jpg') }}'"/>
                    <div class="cat-card-overlay"></div>
                </div>
                <div class="cat-card-body">
                    <div class="cat-card-name">{{ $cat->name }}</div>
                    <div class="cat-card-count">View Products <i class="fa-solid fa-arrow-right"></i></div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- WHY CHOOSE US --}}
<section class="why-section">
    <div class="container">
        <div class="section-header" data-animate>
            <span class="section-tag">Our Strengths</span>
            <h2 class="section-title">Why Choose <span>Shree Kalika</span>?</h2>
            <div class="divider-gold" style="margin:14px auto;"></div>
            <p class="section-sub">We combine quality products, expert knowledge, and customer-first service.</p>
        </div>
        <div class="why-grid">
            @foreach([['award','Quality Products','Every product is evaluated for strength, finish, and functionality before reaching you.'],['coins','Competitive Pricing','Fair pricing with value for money — we help you maximize efficiency within your budget.'],['truck-fast','Timely Delivery','Reliable logistics network ensures your orders reach on time, every time.'],['puzzle-piece','Custom Solutions','Tailored product recommendations and fabricated crates to suit your exact requirements.'],['headset','Expert Support','Our team understands your industry and recommends the most suitable products.'],['handshake','Long-term Partnerships','We build relationships based on trust, honesty, and repeat business from satisfied clients.'],['boxes-stacking','Vast Product Range','500+ products across 8 categories covering every industrial and commercial need.'],['arrow-trend-up','Continuous Growth','Always expanding our range with innovative products matching modern industrial demands.']] as [$icon, $title, $desc])
            <div class="why-card" data-animate>
                <div class="why-icon"><i class="fa-solid fa-{{ $icon }}"></i></div>
                <div class="why-title">{{ $title }}</div>
                <p class="why-desc">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FEATURED PRODUCTS --}}
@if($featured->count())
<section class="products-section" id="products">
    <div class="container">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:16px;margin-bottom:50px;" data-animate>
            <div>
                <span class="section-tag">Our Products</span>
                <h2 class="section-title">Featured <span>Products</span></h2>
                <div class="divider-gold"></div>
            </div>
            <a href="{{ route('products.index') }}" class="btn-outline">View All Products <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="products-slider">
            @foreach($featured as $product)
            <a class="product-card" href="{{ route('product.show', $product->slug) }}" data-animate>
                <div class="product-thumb">
                    @if($product->is_featured)<div class="product-tag">Featured</div>@endif
                    <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" onerror="this.src='{{ asset('images/default-product.jpg') }}'"/>
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
    </div>
</section>
@endif

{{-- INDUSTRIES --}}
<section class="industries-section">
    <div class="container">
        <div class="section-header" data-animate>
            <span class="section-tag">Industries</span>
            <h2 class="section-title">Industries We <span>Serve</span></h2>
            <div class="divider-gold"></div>
            <p class="section-sub">Our products are trusted across industries that demand reliable storage solutions.</p>
        </div>
        <div class="industries-grid">
            @foreach([['industry','Manufacturing'],['warehouse','Warehousing'],['capsules','Pharmaceuticals'],['car','Automotive'],['seedling','Agriculture'],['store','Retail'],['truck','Logistics'],['gears','Engineering'],['hospital','Healthcare'],['apple-whole','Food & Beverage'],['building','Construction'],['shirt','Textiles']] as [$icon, $name])
            <div class="industry-card" data-animate>
                <div class="industry-icon"><i class="fa-solid fa-{{ $icon }}"></i></div>
                <div class="industry-name">{{ $name }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- TESTIMONIALS --}}
<section class="testimonials-section">
    <div class="container">
        <div class="section-header" data-animate>
            <span class="section-tag">Client Reviews</span>
            <h2 class="section-title" style="color:var(--white);">What Our <span>Clients Say</span></h2>
            <div class="divider-gold"></div>
        </div>
        <div class="testi-slider-wrap" data-animate>
            <div class="testi-track" id="testiTrack">
                @foreach([['R','Rajesh Patel','Patel Logistics, Ahmedabad','Shree Kalika delivered our order of 500+ crates on time. Quality exceeded expectations – robust and well-finished.',5],['S','Suresh Shah','Medico Pharma, Surat','Their product range is extensive and Mr. Mayur always helps us pick the right solution for our pharmacy stores.',5],['A','Ankit Mehta','Mehta Auto Components, Kadi','The hand pallet trucks and platform trolleys are still running strong after daily use. A reliable supplier.',4],['N','Nitin Desai','Desai Warehousing, Gandhinagar','The team understood our space constraints and suggested the best layout. Excellent after-sale support.',5],['H','Harshad Trivedi','Trivedi Cold Storage, Mehsana','The fruit crates are perfect for cold storage. Good ventilation, strong build, and stackable design.',5]] as [$init, $name, $company, $text, $stars])
                <div class="testimonial-card">
                    <div class="stars">@for($i=0;$i<5;$i++)<i class="fa-{{ $i<$stars?'solid':'regular' }} fa-star"></i>@endfor</div>
                    <p class="testimonial-text">"{{ $text }}"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">{{ $init }}</div>
                        <div><div class="author-name">{{ $name }}</div><div class="author-company">{{ $company }}</div></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="testi-controls">
            <button class="testi-btn" id="testiBtnPrev"><i class="fa-solid fa-chevron-left"></i></button>
            <div class="testi-dots" id="testiDots"></div>
            <button class="testi-btn" id="testiBtnNext"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-inner" data-animate>
            <span class="section-tag" style="color:var(--gold-light);">Ready to Get Started?</span>
            <h2 class="section-title" style="color:var(--white);">Let's Build Your <span>Storage Solution</span></h2>
            <p>Contact us today to discuss your requirements, get a quote, or request a product catalog.</p>
            <div class="cta-actions">
                <a href="{{ route('contact') }}" class="btn-white"><i class="fa-solid fa-envelope"></i> Enquire Now</a>
                <a href="tel:+917490806940" class="btn-outline" style="border-color:rgba(255,255,255,0.5);color:var(--white);"><i class="fa-solid fa-phone"></i> +91 74908 06940</a>
                <a href="https://wa.me/917490806940" target="_blank" class="btn-outline" style="border-color:#25D366;color:#25D366;"><i class="fa-brands fa-whatsapp"></i> WhatsApp Us</a>
            </div>
        </div>
    </div>
</section>

@endsection
