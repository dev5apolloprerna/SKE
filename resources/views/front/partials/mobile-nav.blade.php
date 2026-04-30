<div class="mobile-nav">
    <div class="mobile-nav-header">
        <div style="display:flex;align-items:center;gap:10px;">
            <img src="{{ asset('images/logo.png') }}" alt="SKE" style="width:40px;border-radius:50%;"/>
            <div style="font-family:'Playfair Display',serif;color:#fff;font-size:0.95rem;font-weight:700;line-height:1.2;">
                Shree Kalika<br/><span style="color:var(--gold);font-size:0.7rem;letter-spacing:0.1em;">Enterprises</span>
            </div>
        </div>
        <button class="mobile-close"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <ul>
        <li class="mobile-nav-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="mobile-nav-item"><a href="{{ route('about') }}">About Us</a></li>
        <li class="mobile-nav-item">
            <a href="{{ route('products.index') }}">Products <i class="fa-solid fa-chevron-down"></i></a>
            <div class="mobile-cat">
                <ul>
                    @foreach($categories ?? [] as $cat)
                    <li class="mobile-cat-item">
                        <a href="{{ route('category.show', $cat->slug) }}">
                            {{ $cat->name }}
                            @if($cat->subcategories->count())<i class="fa-solid fa-chevron-down"></i>@endif
                        </a>
                        @if($cat->subcategories->count())
                        <div class="mobile-sub">
                            <ul>
                                @foreach($cat->subcategories as $sub)
                                <li>
                                    <a href="{{ route('subcategory.show', [$cat->slug, $sub->slug]) }}">{{ $sub->name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
        </li>
        <li class="mobile-nav-item"><a href="{{ route('gallery') }}">Gallery</a></li>
        <li class="mobile-nav-item"><a href="{{ route('contact') }}">Contact</a></li>
    </ul>
    <div style="margin-top:30px;padding-top:20px;border-top:1px solid rgba(200,146,58,0.25);">
        <a href="{{ route('contact') }}" class="btn-primary" style="width:100%;justify-content:center;">
            Get a Free Quote <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</div>
