@extends('layouts.app')

@section('title', 'Log in — Aparri Philippine Coast Guard Boat Tracker')

@section('content')
  @php
    $authNotice = session('status', '');
    $authError = session('error', '');
  @endphp

  <main class="page-hero contact-page">
    <div class="hero-bg" aria-hidden="true"></div>
    <div class="hero-scrim about-page-scrim" aria-hidden="true"></div>
    <div class="auth-inner">
      <section class="contact-card auth-card" aria-labelledby="login-heading">
        <h1 id="login-heading" class="contact-card__title">Log in</h1>

        @if($errors->any())
          <p class="auth-message auth-message--error" role="alert">{{ $errors->first() }}</p>
        @endif
        @if($authError !== '')
          <p class="auth-message auth-message--error" role="alert">{{ $authError }}</p>
        @endif
        @if($authNotice !== '')
          <p class="auth-message auth-message--notice" role="status">{{ $authNotice }}</p>
        @endif

        <form class="auth-form" method="post" action="{{ route('login.post') }}" novalidate>
          @csrf
          <div class="form-field">
            <label class="form-label" for="login-username">Username</label>
            <input
              class="form-input"
              type="text"
              id="login-username"
              name="username"
              autocomplete="username"
              required
              value="{{ old('username', '') }}"
            />
          </div>
          <div class="form-field">
            <label class="form-label" for="login-password">Password</label>
            <input
              class="form-input"
              type="password"
              id="login-password"
              name="password"
              autocomplete="current-password"
              required
            />
          </div>
          <div class="form-field form-field--inline">
            <label class="form-check">
              <input type="checkbox" name="remember" value="1" />
              <span>Remember me</span>
            </label>
          </div>
          <button type="submit" class="btn-login btn-login--block">Log in</button>
        </form>

        <p class="auth-switch">
          No account yet? <a href="{{ route('register') }}">Register</a>
        </p>
      </section>
    </div>
  </main>
@endsection
