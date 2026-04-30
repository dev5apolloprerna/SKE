@extends('layouts.front_app')
@section('title','Contact Us – Shree Kalika Enterprises')
@section('meta_desc','Contact Shree Kalika Enterprises for product enquiries, quotes, and support. Phone: +91 74908 06940 | Email: info@ske.com')

@section('content')
<div class="page-hero">
    <div class="container page-hero-content">
        <div class="breadcrumb-nav">
            <a href="{{ route('home') }}">Home</a><span class="sep">/</span><span>Contact Us</span>
        </div>
        <h1 class="page-title">Get In <span>Touch</span></h1>
        <p class="page-subtitle">We'd love to hear from you. Send us a message or call us directly for any product enquiries or quotes.</p>
    </div>
</div>

<section class="contact-section">
    <div class="container">
        <div class="row g-4">

            {{-- INFO CARD --}}
            <div class="col-lg-4" data-animate>
                <div class="contact-info-card">
                    <div class="contact-info-title">Contact Information</div>
                    <p class="contact-info-sub">Reach out to us through any of the channels below. We respond within one business day.</p>

                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div>
                            <div class="contact-info-label">Address</div>
                            <div class="contact-info-value">Kadi – 382715,<br/>Mehsana, Gujarat, India</div>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fa-solid fa-phone"></i></div>
                        <div>
                            <div class="contact-info-label">Phone</div>
                            <div class="contact-info-value"><a href="tel:+917490806940">+91 74908 06940</a></div>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div>
                            <div class="contact-info-label">Email</div>
                            <div class="contact-info-value"><a href="mailto:info@ske.com">info@ske.com</a></div>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fa-solid fa-globe"></i></div>
                        <div>
                            <div class="contact-info-label">Website</div>
                            <div class="contact-info-value"><a href="https://www.ske.com" target="_blank">www.ske.com</a></div>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fa-solid fa-clock"></i></div>
                        <div>
                            <div class="contact-info-label">Business Hours</div>
                            <div class="contact-info-value">Mon – Sat: 9:00 AM – 6:00 PM</div>
                        </div>
                    </div>

                    <div style="margin-top:28px;display:flex;gap:10px;">
                        <a href="https://wa.me/917490806940" target="_blank" style="flex:1;background:#25D366;color:#fff;font-size:0.85rem;font-weight:700;padding:11px 10px;border-radius:var(--radius);display:flex;align-items:center;justify-content:center;gap:7px;text-decoration:none;transition:opacity 0.2s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                            <i class="fa-brands fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="tel:+917490806940" style="flex:1;background:var(--gold);color:var(--navy);font-size:0.85rem;font-weight:700;padding:11px 10px;border-radius:var(--radius);display:flex;align-items:center;justify-content:center;gap:7px;text-decoration:none;transition:opacity 0.2s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                            <i class="fa-solid fa-phone"></i> Call Us
                        </a>
                    </div>
                </div>
            </div>

            {{-- FORM CARD --}}
            <div class="col-lg-8" data-animate data-delay="2">
                <div class="contact-form-card">
                    <div class="contact-form-title">Send Us a Message</div>
                    <p class="contact-form-sub">Fill in the form below and our team will get back to you promptly.</p>

                    @if(session('success'))
                    <div class="alert-success-ske"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                    <div class="alert-error-ske"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}">
                        @csrf
                        <div class="form-row" style="margin-bottom:16px;">
                            <div>
                                <label class="ske-form-label">Full Name <span style="color:var(--crimson);">*</span></label>
                                <input type="text" name="name" class="ske-form-control" placeholder="Your full name" value="{{ old('name') }}" required/>
                            </div>
                            <div>
                                <label class="ske-form-label">Company Name</label>
                                <input type="text" name="company_name" class="ske-form-control" placeholder="Your company" value="{{ old('company_name') }}"/>
                            </div>
                        </div>
                        <div class="form-row" style="margin-bottom:16px;">
                            <div>
                                <label class="ske-form-label">Phone Number <span style="color:var(--crimson);">*</span></label>
                                <input type="tel" name="phone" class="ske-form-control" placeholder="+91 XXXXX XXXXX" value="{{ old('phone') }}" required/>
                            </div>
                            <div>
                                <label class="ske-form-label">Email Address</label>
                                <input type="email" name="email" class="ske-form-control" placeholder="your@email.com" value="{{ old('email') }}"/>
                            </div>
                        </div>
                        <div style="margin-bottom:16px;">
                            <label class="ske-form-label">Message</label>
                            <textarea name="message" class="ske-form-control" rows="5" placeholder="Tell us about your requirements, products you're interested in, quantities, etc.">{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn-primary" style="width:100%;justify-content:center;padding:14px;">
                            <i class="fa-solid fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MAP --}}
<div class="map-section">
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3667.5!2d72.75!3d23.27!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zS2FkaSwgR3VqYXJhdA!5e0!3m2!1sen!2sin!4v1"
        width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>
@endsection
