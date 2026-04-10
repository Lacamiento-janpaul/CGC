@extends('layouts.user')

@section('title', 'Account Settings — Aparri Philippine Coast Guard')

@section('content')
  <main class="settings-page">
    <div class="settings-page__header">
      <h1 class="profile-title">Account Settings</h1>
      <p class="settings-page__subtitle">Manage your account, security, and preferences</p>
    </div>
    <div class="settings-page__container">
      <h1 class="profile-title">Account Settings</h1>
      <div class="settings-grid">
        <a class="settings-card" href="{{ route('user.change-username') }}">
          <div class="settings-card__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" />
              <path d="M4 20c0-4 4-6 8-6s8 2 8 6" />
            </svg>
          </div>
          <h2 class="settings-card__title">Change Username</h2>
          <p class="settings-card__text">Update your account username securely.</p>
        </a>

        <a class="settings-card" href="{{ route('user.change-password') }}">
          <div class="settings-card__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <rect x="3" y="11" width="18" height="11" rx="2" />
              <path d="M7 11V7a5 5 0 0 1 10 0v4" />
              <path d="M8 16h8" />
            </svg>
          </div>
          <h2 class="settings-card__title">Change Password</h2>
          <p class="settings-card__text">Update your password for added security.</p>
        </a>

        <a class="settings-card settings-card--danger" href="{{ route('user.delete-account') }}">
          <div class="settings-card__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M3 6h18" />
              <path d="M8 6V4h8v2" />
              <rect x="6" y="6" width="12" height="14" rx="2" />
              <line x1="10" y1="11" x2="10" y2="17" />
              <line x1="14" y1="11" x2="14" y2="17" />
            </svg>
          </div>
          <h2 class="settings-card__title">Delete Account</h2>
          <p class="settings-card__text">Permanently remove your account from the system.</p>
        </a>
      </div>
    </div>
  </main>
@endsection
