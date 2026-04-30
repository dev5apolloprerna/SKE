<nav class="navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Shree Kalika Enterprises"/>
            <div class="brand-text">
                <div class="brand-name">Shree Kalika<br/>Enterprises</div>
                <div class="brand-tagline">Since 2020 · ISO Certified</div>
            </div>
        </a>

        <ul class="nav-menu">
            <li class="nav-item {{ Request::routeIs('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item {{ Request::routeIs('about') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('about') }}">About Us</a>
            </li>

            {{-- Dynamic Products Mega Menu --}}
            <li class="nav-item {{ Request::routeIs('products.*','category.*','subcategory.*','product.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('products.index') }}">
                    Products <i class="fa-solid fa-chevron-down arrow"></i>
                </a>
                <div class="mega-menu">
                    <div class="mega-menu-header">
                        <i class="fa-solid fa-boxes-stacking" style="color:var(--gold);font-size:0.85rem;"></i>
                        <span>Product Categories</span>
                    </div>
                    <ul class="category-list">
                        @foreach($categories ?? [] as $cat)
                        <li class="cat-item">
                            <a class="cat-link" href="{{ route('category.show', $cat->slug) }}">
                                <i class="cat-icon"><i class="fa-solid fa-box"></i></i>
                                <span class="cat-label">{{ $cat->name }}</span>
                                @if($cat->subcategories->count())
                                <i class="fa-solid fa-chevron-right chevron"></i>
                                @endif
                            </a>
                            @if($cat->subcategories->count())
                            <ul class="sub-menu">
                                @foreach($cat->subcategories as $sub)
                                <li>
                                    <a class="sub-link" href="{{ route('subcategory.show', [$cat->slug, $sub->slug]) }}">
                                        {{ $sub->name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </li>

            <li class="nav-item {{ Request::routeIs('gallery') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('gallery') }}">Gallery</a>
            </li>
            <li class="nav-item {{ Request::routeIs('contact') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('contact') }}">Contact</a>
            </li>
        </ul>

        <div class="nav-cta">
            <a href="{{ route('contact') }}" class="btn-primary d-none d-lg-inline-flex">
                Get Quote <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <button class="hamburger" aria-label="Toggle navigation">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>
