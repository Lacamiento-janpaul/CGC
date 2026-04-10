@extends('layouts.user')

@section('title', 'Change Password — Aparri Philippine Coast Guard')

@section('content')
  @php
    $authNotice = session('status', '');
    $authError = session('error', '');
  @endphp

  <main class="page-hero contact-page">
    <div class="hero-bg" aria-hidden="true"></div>
    <div class="hero-scrim about-page-scrim" aria-hidden="true"></div>
    <div class="auth-inner">
      <section class="contact-card auth-card" aria-labelledby="change-password-heading">
        <h1 id="change-password-heading" class="contact-card__title">Change Password</h1>

        @if($errors->any())
          <p class="auth-message auth-message--error" role="alert">{{ $errors->first() }}</p>
        @endif
        @if($authError !== '')
          <p class="auth-message auth-message--error" role="alert">{{ $authError }}</p>
        @endif
        @if($authNotice !== '')
          <p class="auth-message auth-message--notice" role="status">{{ $authNotice }}</p>
        @endif

        <form class="auth-form" method="post" action="{{ route('user.change-password.post') }}" novalidate>
          @csrf
          <div class="form-field">
            <label class="form-label" for="current-password">Current password</label>
            <input
              class="form-input"
              type="password"
              id="current-password"
              name="current_password"
              autocomplete="current-password"
              required
            />
          </div>
          <div class="form-field">
            <label class="form-label" for="new-password">Create new password</label>
            <input
              class="form-input"
              type="password"
              id="new-password"
              name="new_password"
              autocomplete="new-password"
              required
              minlength="8"
            />
          </div>
          <div class="form-field">
            <label class="form-label" for="confirm-password">Re-enter new password</label>
            <input
              class="form-input"
              type="password"
              id="confirm-password"
              name="new_password_confirmation"
              autocomplete="new-password"
              required
              minlength="8"
            />
          </div>
          <button type="submit" class="btn-login btn-login--block">Save</button>
        </form>

        <p class="auth-switch">
          <a href="{{ route('user.settings') }}">Back to settings</a>
        </p>
      </section>
    </div>
  </main>
@endsection
