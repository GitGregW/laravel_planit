<!doctype html>
<link rel="stylesheet" href="/css/styles.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class="navbar-second-background"></div>
<div class="navbar">
    <nav class="navbar--fixed">
        <ul class="navbar__items">
            <li class="navbar__item"><a class="navbar__link" href="/events">Explore</a></li>
            <li class="navbar__item"><a class="navbar__link" href="/plans">Plans</a></li>
        </ul>
        <div class="navbar__title">
            <a class="navbar__link" href="/"><span style="color:yellow;">PLAN</span>IT.</a>
        </div>
    </nav>
    {{-- <div style="height: 65px; width:inherit;"></div>
    <h2 class="navbar__slogan">
        <span class="navbar__slogan">Explore</span> - <span class="navbar__slogan">Plan</span> - <span class="navbar__slogan">Do</span>
    </h2> --}}
    @if (session()->has('success'))
        <div>
            <p>{{ session('success') }}</p>
        </div>
    @endif
</div>

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
