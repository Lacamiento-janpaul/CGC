@extends('layouts.admin')

@section('title', 'Delete Account — Aparri Philippine Coast Guard')

@section('content')
  @php
    $authNotice = session('status', '');
    $authError = session('error', '');
  @endphp

  <main class="page-hero contact-page">
    <div class="hero-bg" aria-hidden="true"></div>
    <div class="hero-scrim about-page-scrim" aria-hidden="true"></div>
    <div class="auth-inner">
      <section class="contact-card auth-card" aria-labelledby="delete-account-heading">
        <h1 id="delete-account-heading" class="contact-card__title">Delete Account</h1>

        @if($authError !== '')
          <p class="auth-message auth-message--error" role="alert">{{ $authError }}</p>
        @endif
        @if($authNotice !== '')
          <p class="auth-message auth-message--notice" role="status">{{ $authNotice }}</p>
        @endif

        <form class="auth-form" method="post" action="{{ route('admin.delete-account.post') }}" novalidate>
          @csrf
          <div class="form-field">
            <label class="form-label" for="password">Enter password</label>
            <input
              class="form-input"
              type="password"
              id="password"
              name="password"
              autocomplete="current-password"
              required
            />
          </div>
          <div class="form-field">
            <label class="form-label" for="confirm-password">Re-enter password</label>
            <input
              class="form-input"
              type="password"
              id="confirm-password"
              name="password_confirmation"
              autocomplete="current-password"
              required
            />
          </div>
          <button type="submit" class="btn-login btn-login--block">Delete Account</button>
        </form>

        <p class="auth-switch">
          <a href="{{ route('admin.settings') }}">Back to settings</a>
        </p>
      </section>
    </div>
  </main>
@endsection
