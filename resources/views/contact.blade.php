@extends('layouts.app')

@section('title', 'Contact Us — Aparri Philippine Coast Guard Boat Tracker')

@section('content')
  <main class="page-hero contact-page">
    <div class="hero-bg" aria-hidden="true"></div>
    <div class="hero-scrim about-page-scrim" aria-hidden="true"></div>
    <div class="contact-inner">
      <section class="contact-card" aria-labelledby="contact-heading">
        <h1 id="contact-heading" class="contact-card__title">Visit our social media platform</h1>
        <ul class="contact-list">
          <li>
            <a class="contact-list__row" href="https://www.facebook.example.com" target="_blank" rel="noopener noreferrer">
              <span class="contact-list__icon contact-list__icon--facebook" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="40" height="40" focusable="false">
                  <circle cx="12" cy="12" r="12" fill="#1877f2" />
                  <path
                    fill="#fff"
                    d="M13.5 21.5v-7.3H11V11h2.5V8.9C13.5 6.4 15.1 5 17.8 5H20v3.2h-1.9c-1 0-1.3.5-1.3 1.4V11H20l-.4 3.2h-3.1v7.3h-3.2z"
                  />
                </svg>
              </span>
              <span class="contact-list__text">www.facebook.example.com</span>
            </a>
          </li>
          <li>
            <a class="contact-list__row" href="tel:+639000000000">
              <span class="contact-list__icon contact-list__icon--phone" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="40" height="40" focusable="false">
                  <path
                    fill="none"
                    stroke="#1877f2"
                    stroke-width="1.35"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M8.5 4h2l1.2 3-1.3 1.6a12 12 0 006.1 6.1L18 13.3l3 1.3V17c0 1-1 2-2.2 2.2C11.4 20.5 3.5 12.6 4.8 5.2 5 4 6 3 7 3h1.5z"
                  />
                  <path
                    fill="none"
                    stroke="#1877f2"
                    stroke-width="1.2"
                    stroke-linecap="round"
                    d="M17 3.5c1.7 1.2 3 2.8 3.8 4.7M17 7c.9.7 1.6 1.6 2 2.7"
                  />
                </svg>
              </span>
              <span class="contact-list__text">09x-xxxx-xxx</span>
            </a>
          </li>
          <li>
            <a class="contact-list__row" href="mailto:contact@example.email.com">
              <span class="contact-list__icon contact-list__icon--email" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="40" height="40" focusable="false">
                  <circle cx="12" cy="12" r="12" fill="#1a1a1a" />
                  <path
                    fill="none"
                    stroke="#fff"
                    stroke-width="1.35"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M7 9h10v8H7V9zm0 0l5 3.5L17 9"
                  />
                </svg>
              </span>
              <span class="contact-list__text">example.email.com</span>
            </a>
          </li>
        </ul>
        <p class="contact-card__address">
          or visit us on our station located at Minanga Aparri Cagayan
        </p>
      </section>
    </div>
  </main>
@endsection
