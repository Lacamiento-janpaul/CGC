@extends('layouts.user')

@section('title', 'Change Username — Aparri Philippine Coast Guard')

@section('content')
  @php
    $authNotice = session('status', '');
    $authError = session('error', '');
  @endphp

  <main class="page-hero contact-page">
    <div class="hero-bg" aria-hidden="true"></div>
    <div class="hero-scrim about-page-scrim" aria-hidden="true"></div>
    <div class="auth-inner">
      <section class="contact-card auth-card" aria-labelledby="change-username-heading">
        <h1 id="change-username-heading" class="contact-card__title">Change Username</h1>

        @if($errors->any())
          <p class="auth-message auth-message--error" role="alert">{{ $errors->first() }}</p>
        @endif
        @if($authError !== '')
          <p class="auth-message auth-message--error" role="alert">{{ $authError }}</p>
        @endif
        @if($authNotice !== '')
          <p class="auth-message auth-message--notice" role="status">{{ $authNotice }}</p>
        @endif

        <form class="auth-form" method="post" action="{{ route('user.change-username.post') }}" novalidate>
          @csrf
          <div class="form-field">
            <label class="form-label" for="current-username">Current username</label>
            <input
              class="form-input"
              type="text"
              id="current-username"
              name="current_username"
              autocomplete="username"
              required
              value="{{ old('current_username', auth()->user()->username) }}"
            />
          </div>
          <div class="form-field">
            <label class="form-label" for="new-username">Create new username</label>
            <input
              class="form-input"
              type="text"
              id="new-username"
              name="new_username"
              autocomplete="username"
              required
              minlength="3"
              value="{{ old('new_username', '') }}"
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
