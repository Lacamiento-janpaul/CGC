@extends('layouts.admin')

@section('title', 'User Profile — Boat Tracker')

@section('content')
  <main class="profile-page" id="profile-page">
    <div style="padding: 1.5rem max(1rem, env(safe-area-inset-right)) 0 max(1rem, env(safe-area-inset-left));display:flex;gap:1rem;align-items:center;">
      <a href="{{ route('admin.dashboard') }}" class="dashboard-btn" style="margin:0;">← Back to dashboard</a>
    </div>

    <div class="profile-page__container">
      <section class="profile-overview-card" aria-labelledby="profile-heading">
        <div class="profile-avatar profile-avatar--large" aria-hidden="true">
          @if($user->avatar)
            <img src="{{ asset($user->avatar) }}" alt="Profile picture" />
          @else
            <span style="font-size: 2rem;">👤</span>
          @endif
        </div>
        <p class="profile-overview-username">{{ $user->name ?? $user->username }}</p>
        <div class="profile-upload">
          <h2 id="upload-photo-heading" class="profile-card__title">User Profile</h2>
          <p style="margin: 0.75rem 0 0; color: #555;">Viewing information for {{ $user->name ?? $user->username }}.</p>
        </div>
      </section>

      <div class="profile-grid">
        <aside class="profile-card profile-card--personal" aria-labelledby="personal-info-heading">
          <h2 id="personal-info-heading" class="profile-card__title">Personal Information</h2>
          <ul class="profile-list">
            <li class="profile-list__item">
              <span class="profile-list__label">Name</span>
              <span>{{ $user->name ?? '—' }}</span>
            </li>
            <li class="profile-list__item">
              <span class="profile-list__label">Username</span>
              <span>{{ $user->username }}</span>
            </li>
            <li class="profile-list__item">
              <span class="profile-list__label">Email</span>
              <span>{{ $user->email }}</span>
            </li>
            <li class="profile-list__item">
              <span class="profile-list__label">Age</span>
              <span>{{ $user->profile['age'] ?? '—' }}</span>
            </li>
            <li class="profile-list__item">
              <span class="profile-list__label">Sex</span>
              <span>{{ $user->profile['sex'] ?? '—' }}</span>
            </li>
            <li class="profile-list__item">
              <span class="profile-list__label">Date of birth</span>
              <span>{{ $user->profile['date_of_birth'] ?? '—' }}</span>
            </li>
            <li class="profile-list__item">
              <span class="profile-list__label">Nationality</span>
              <span>{{ $user->profile['nationality'] ?? '—' }}</span>
            </li>
            <li class="profile-list__item">
              <span class="profile-list__label">Residential address</span>
              <span>{{ $user->profile['residential_address'] ?? '—' }}</span>
            </li>
            <li class="profile-list__item">
              <span class="profile-list__label">Business address</span>
              <span>{{ $user->profile['business_address'] ?? '—' }}</span>
            </li>
            <li class="profile-list__item">
              <span class="profile-list__label">Contact number</span>
              <span>{{ $user->profile['contact_number'] ?? '—' }}</span>
            </li>
            <li class="profile-list__item">
              <span class="profile-list__label">Emergency contact number</span>
              <span>{{ $user->profile['emergency_contact_number'] ?? '—' }}</span>
            </li>
            <li class="profile-list__item">
              <span class="profile-list__label">Role</span>
              <span>{{ ucfirst($user->role) }}</span>
            </li>
            <li class="profile-list__item">
              <span class="profile-list__label">Registered at</span>
              <span>{{ $user->created_at?->format('F j, Y') ?? '—' }}</span>
            </li>
          </ul>
        </aside>

        <div class="profile-right">
          <section class="profile-card profile-card--vessel" aria-labelledby="vessel-info-heading">
            <h2 id="vessel-info-heading" class="profile-card__title">Vessel Information</h2>
            <ul class="profile-list">
              <li class="profile-list__item">
                <span class="profile-list__label">Name of vessel</span>
                <span>{{ $user->profile['vessel_name'] ?? '—' }}</span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Security Number</span>
                <span>{{ $user->profile['security_number'] ?? '—' }}</span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Former name and Registry</span>
                <span>{{ $user->profile['former_name_registry'] ?? '—' }}</span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Home Port</span>
                <span>{{ $user->profile['home_port'] ?? '—' }}</span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Date of issuance of Certificate Vessel Registry</span>
                <span>{{ $user->profile['certificate_issuance_date'] ?? '—' }}</span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Certificate Expiration</span>
                <span>{{ $user->profile['certificate_expiration'] ?? '—' }}</span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Material Hull</span>
                <span>{{ $user->profile['material_hull'] ?? '—' }}</span>
              </li>
            </ul>
          </section>

          <section class="profile-card profile-card--dimensions" aria-labelledby="dimensions-heading">
            <h2 id="dimensions-heading" class="profile-card__title">Dimensions & Engine</h2>
            <ul class="profile-list profile-list--stacked">
              <li class="profile-list__item">
                <span class="profile-list__label">Length (Meters)</span>
                <span>{{ $user->profile['length_meters'] ?? '—' }}</span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Breadth (Meters)</span>
                <span>{{ $user->profile['breadth_meters'] ?? '—' }}</span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Depth (Meters)</span>
                <span>{{ $user->profile['depth_meters'] ?? '—' }}</span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Gross Tonnage</span>
                <span>{{ $user->profile['gross_tonnage'] ?? '—' }}</span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Net Tonnage</span>
                <span>{{ $user->profile['net_tonnage'] ?? '—' }}</span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Dead Weight</span>
                <span>{{ $user->profile['dead_weight'] ?? '—' }}</span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Engine Make</span>
                <span>{{ $user->profile['engine_make'] ?? '—' }}</span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Serial Number</span>
                <span>{{ $user->profile['serial_number'] ?? '—' }}</span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Horse Power</span>
                <span>{{ $user->profile['horse_power'] ?? '—' }}</span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Speed</span>
                <span>{{ $user->profile['speed'] ?? '—' }}</span>
              </li>
            </ul>
          </section>
        </div>
      </div>
    </div>
  </main>
@endsection
