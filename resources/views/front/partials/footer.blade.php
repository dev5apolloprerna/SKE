<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <img src="{{ asset('images/logo.png') }}" alt="SKE Logo"/>
                <div style="font-family:'Playfair Display',serif;font-size:1.15rem;font-weight:700;color:var(--white);margin-bottom:10px;margin-top:12px;">Shree Kalika Enterprises</div>
                <p>Your reliable partner for industrial storage, plastic products, and material handling solutions. Serving businesses across Gujarat and India since 2020.</p>
                <div class="footer-social">
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    <a href="https://wa.me/917490806940" target="_blank" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('products.index') }}">Products</a></li>
                    <li><a href="{{ route('gallery') }}">Gallery</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Categories</h4>
                <ul class="footer-links">
                    @foreach($categories ?? [] as $cat)
                    <li><a href="{{ route('category.show', $cat->slug) }}">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact Us</h4>
                <div class="footer-contact">
                    <div class="footer-contact-item"><i class="fa-solid fa-location-dot"></i><span>Kadi – 382715, Mehsana, Gujarat, India</span></div>
                    <div class="footer-contact-item"><i class="fa-solid fa-phone"></i><span><a href="tel:+917490806940" style="color:inherit;">+91 74908 06940</a></span></div>
                    <div class="footer-contact-item"><i class="fa-solid fa-envelope"></i><span><a href="mailto:info@ske.com" style="color:inherit;">info@ske.com</a></span></div>
                    <div class="footer-contact-item"><i class="fa-solid fa-globe"></i><span><a href="https://www.ske.com" target="_blank" style="color:inherit;">www.ske.com</a></span></div>
                    <div class="footer-contact-item"><i class="fa-solid fa-clock"></i><span>Mon–Sat: 9:00 AM – 6:00 PM</span></div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Shree Kalika Enterprises. All Rights Reserved.</p>
            <p>Designed for Industrial Excellence</p>
        </div>
    </div>
</footer>
