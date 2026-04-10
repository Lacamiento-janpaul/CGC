@extends('layouts.app')

@section('title', 'Register — Aparri Philippine Coast Guard Boat Tracker')

@section('content')
  @php
    $authNotice = session('status', '');
    $authError = session('error', '');
  @endphp

  <main class="page-hero contact-page">
    <div class="hero-bg" aria-hidden="true"></div>
    <div class="hero-scrim about-page-scrim" aria-hidden="true"></div>
    <div class="auth-inner">
      <section class="contact-card auth-card" aria-labelledby="register-heading">
        <h1 id="register-heading" class="contact-card__title">Create an account</h1>

        @if($errors->any())
          <p class="auth-message auth-message--error" role="alert">{{ $errors->first() }}</p>
        @endif
        @if($authError !== '')
          <p class="auth-message auth-message--error" role="alert">{{ $authError }}</p>
        @endif
        @if($authNotice !== '')
          <p class="auth-message auth-message--notice" role="status">{{ $authNotice }}</p>
        @endif

        <form class="auth-form" method="post" action="{{ route('register.post') }}" novalidate>
          @csrf
          <div class="form-field">
            <label class="form-label" for="reg-name">Full name</label>
            <input
              class="form-input"
              type="text"
              id="reg-name"
              name="name"
              autocomplete="name"
              required
              value="{{ old('name', '') }}"
            />
          </div>
          <div class="form-field">
            <label class="form-label" for="reg-username">Username</label>
            <input
              class="form-input"
              type="text"
              id="reg-username"
              name="username"
              autocomplete="username"
              required
              minlength="3"
              maxlength="64"
              pattern="[a-zA-Z0-9_-]+"
              title="Letters, numbers, underscores, and hyphens only"
              value="{{ old('username', '') }}"
            />
          </div>
          <div class="form-field">
            <label class="form-label" for="reg-email">Email</label>
            <input
              class="form-input"
              type="email"
              id="reg-email"
              name="email"
              autocomplete="email"
              required
              value="{{ old('email', '') }}"
            />
          </div>
          <div class="form-field">
            <label class="form-label" for="reg-password">Password</label>
            <input
              class="form-input"
              type="password"
              id="reg-password"
              name="password"
              autocomplete="new-password"
              required
              minlength="8"
            />
          </div>
          <div class="form-field">
            <label class="form-label" for="reg-password-confirm">Confirm password</label>
            <input
              class="form-input"
              type="password"
              id="reg-password-confirm"
              name="password_confirmation"
              autocomplete="new-password"
              required
              minlength="8"
            />
          </div>
          <button type="submit" class="btn-login btn-login--block">Register</button>
        </form>

        <p class="auth-switch">
          Already have an account? <a href="{{ route('login') }}">Log in</a>
        </p>
      </section>
    </div>
  </main>
@endsection
