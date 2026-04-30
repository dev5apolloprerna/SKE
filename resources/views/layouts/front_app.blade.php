<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'Shree Kalika Enterprises – Industrial Storage & Material Handling')</title>
    <meta name="description" content="@yield('meta_desc', 'Leading supplier of plastic crates, storage bins, industrial pallets, shelving systems and material handling equipment in Gujarat, India.')"/>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
    <link href="{{ asset('front-assets/css/ske.css') }}" rel="stylesheet"/>
    @stack('styles')
</head>
<body class="{{ Request::routeIs('home') ? 'page-home' : 'page-inner' }}">

@include('front.partials.topbar')
@include('front.partials.navbar')
@include('front.partials.mobile-nav')

<main>@yield('content')</main>

@include('front.partials.footer')
@include('front.partials.whatsapp')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('front-assets/js/ske.js') }}"></script>
@stack('scripts')
</body>
</html>
