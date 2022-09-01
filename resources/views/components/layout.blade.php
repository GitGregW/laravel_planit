<!doctype html>
<link rel="stylesheet" href="/css/styles.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="navbar__container">
    <nav class="navbar">
        <a class="navbar__link {{ request()->is('events') ? 'navbar__link--active' : '' }}"
            href="/events">Explore</a>
        <a class="navbar__link {{ request()->is('plans') ? 'navbar__link--active' : '' }}"
            href="{{ auth()->user() ? '/bookings/'.auth()->user()->id.'/review' : '/login' }}">Plans</a>
    </nav>

    <div class="navbar__title">
        <a class="navbar__link navbar__link--title" href="/"><span style="color:yellow;">PLAN</span>IT.</a>
    </div>

    <nav class="navbar navbar--right">
        @auth
        <a href="#">{{ auth()->user()->name }}</a>
            <a class="navbar__link" href="/logout">Logout</a>
        @else
            <a class="navbar__link {{ request()->is('login') ? 'navbar__link--active' : '' }}"
                href="/login">Login</a>
        @endauth
    </nav>
</div>

@if (session()->has('success'))
<div class="message__container">
    <p class="message__text">{{ session('success') }}</p>
</div>
@endif

<body>
{{ $content }}
</body>

<style>

</style>

<!-- FOOTER -->
<div class="footer">
    <div class="footer__head">
        <div class="footer__links">
            <span>
                <a href="/" class="footer__link"><svg class="feather" style="stroke:yellow;"><use href="/icons/feather-sprite.svg#facebook"/></svg></a>
            </span>
            <span>
                <a href="/" class="footer__link"><svg class="feather" style="stroke:yellow;"><use href="/icons/feather-sprite.svg#instagram"/></svg></a>
            </span>
            <span>
                <a href="/" class="footer__link"><svg class="feather" style="stroke:yellow;"><use href="/icons/feather-sprite.svg#twitter"/></svg></a>
            </span>
        </div>
        <span>Copyright © Example.</span>
    </div>
    <div class="footer__body">
        <div class="footer__links--vertical">
            <a class="footer__link" href="/about">About Us</a>
            <a class="footer__link" href="/contact">Contact</a>
        </div>
    </div>
</div>
