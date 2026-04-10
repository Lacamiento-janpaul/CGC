@extends('layouts.admin')

@section('title', 'Admin Profile — Boat Tracker')

@section('content')
  <main class="profile-page" id="profile-page">
    <form method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
      @csrf
      <div class="profile-page__container">
        <section class="profile-overview-card" aria-labelledby="profile-heading">
          <div class="profile-avatar profile-avatar--large" aria-hidden="true">
            @if(auth()->user()->avatar)
              <img src="{{ asset(auth()->user()->avatar) }}" alt="Profile picture" />
            @else
              <span style="font-size: 2rem;">👤</span>
            @endif
          </div>
          <p class="profile-overview-username">{{ auth()->user()->name ?? auth()->user()->username }}</p>
          <div class="profile-upload">
            <h2 id="upload-photo-heading" class="profile-card__title">Upload Profile Picture</h2>
            <input class="profile-upload__input" type="file" name="avatar" accept="image/*" />
            <button type="submit" class="btn-login btn-login--secondary">Save profile picture</button>
          </div>
        </section>

        <div class="profile-grid">
          <aside class="profile-card profile-card--personal" aria-labelledby="personal-info-heading">
            <h2 id="personal-info-heading" class="profile-card__title">Personal Information</h2>
            <ul class="profile-list">
              <li class="profile-list__item">
                <span class="profile-list__label">Name</span>
                <span class="profile-list__value">
                  <input class="profile-input" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" style="width:100%; border:none; background:transparent; outline:none;" />
                </span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Username</span>
                <span class="profile-list__value">
                  <input class="profile-input" type="text" name="username" value="{{ auth()->user()->username }}" readonly style="width:100%; border:none; background:transparent; outline:none;" />
                </span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Email</span>
                <span class="profile-list__value">
                  <input class="profile-input" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" style="width:100%; border:none; background:transparent; outline:none;" />
                </span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Age</span>
                <span class="profile-list__value">
                  <input class="profile-input" type="text" name="age" value="{{ old('age', auth()->user()->profile['age'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                </span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Sex</span>
                <span class="profile-list__value">
                  <input class="profile-input" type="text" name="sex" value="{{ old('sex', auth()->user()->profile['sex'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                </span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Date of Birth</span>
                <span class="profile-list__value">
                  <input class="profile-input" type="text" name="date_of_birth" value="{{ old('date_of_birth', auth()->user()->profile['date_of_birth'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                </span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Nationality</span>
                <span class="profile-list__value">
                  <input class="profile-input" type="text" name="nationality" value="{{ old('nationality', auth()->user()->profile['nationality'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                </span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Residential Address</span>
                <span class="profile-list__value">
                  <input class="profile-input" type="text" name="residential_address" value="{{ old('residential_address', auth()->user()->profile['residential_address'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                </span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Business Address</span>
                <span class="profile-list__value">
                  <input class="profile-input" type="text" name="business_address" value="{{ old('business_address', auth()->user()->profile['business_address'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                </span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Contact Number</span>
                <span class="profile-list__value">
                  <input class="profile-input" type="text" name="contact_number" value="{{ old('contact_number', auth()->user()->profile['contact_number'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                </span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Emergency Contact Number</span>
                <span class="profile-list__value">
                  <input class="profile-input" type="text" name="emergency_contact_number" value="{{ old('emergency_contact_number', auth()->user()->profile['emergency_contact_number'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                </span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Role</span>
                <span class="profile-list__value">{{ ucfirst(auth()->user()->role) }}</span>
              </li>
              <li class="profile-list__item">
                <span class="profile-list__label">Registered At</span>
                <span class="profile-list__value">{{ auth()->user()->created_at?->format('F j, Y') }}</span>
              </li>
            </ul>
          </aside>

          <div class="profile-right">
            <section class="profile-card profile-card--vessel" aria-labelledby="vessel-info-heading">
              <h2 id="vessel-info-heading" class="profile-card__title">Vessel Information</h2>
              <ul class="profile-list">
                <li class="profile-list__item">
                  <span class="profile-list__label">Name of vessel</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="vessel_name" value="{{ old('vessel_name', auth()->user()->profile['vessel_name'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
                <li class="profile-list__item">
                  <span class="profile-list__label">Security Number</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="security_number" value="{{ old('security_number', auth()->user()->profile['security_number'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
                <li class="profile-list__item">
                  <span class="profile-list__label">Former name and Registry</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="former_name_registry" value="{{ old('former_name_registry', auth()->user()->profile['former_name_registry'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
                <li class="profile-list__item">
                  <span class="profile-list__label">Home Port</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="home_port" value="{{ old('home_port', auth()->user()->profile['home_port'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
                <li class="profile-list__item">
                  <span class="profile-list__label">Date of issuance of Certificate Vessel Registry</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="certificate_issuance_date" value="{{ old('certificate_issuance_date', auth()->user()->profile['certificate_issuance_date'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
                <li class="profile-list__item">
                  <span class="profile-list__label">Certificate Expiration</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="certificate_expiration" value="{{ old('certificate_expiration', auth()->user()->profile['certificate_expiration'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
                <li class="profile-list__item">
                  <span class="profile-list__label">Material Hull</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="material_hull" value="{{ old('material_hull', auth()->user()->profile['material_hull'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
              </ul>
            </section>

            <section class="profile-card profile-card--dimensions" aria-labelledby="dimensions-heading">
              <h2 id="dimensions-heading" class="profile-card__title">Dimensions & Engine</h2>
              <ul class="profile-list profile-list--stacked">
                <li class="profile-list__item">
                  <span class="profile-list__label">Length (Meters)</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="length_meters" value="{{ old('length_meters', auth()->user()->profile['length_meters'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
                <li class="profile-list__item">
                  <span class="profile-list__label">Breadth (Meters)</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="breadth_meters" value="{{ old('breadth_meters', auth()->user()->profile['breadth_meters'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
                <li class="profile-list__item">
                  <span class="profile-list__label">Depth (Meters)</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="depth_meters" value="{{ old('depth_meters', auth()->user()->profile['depth_meters'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
                <li class="profile-list__item">
                  <span class="profile-list__label">Gross Tonnage</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="gross_tonnage" value="{{ old('gross_tonnage', auth()->user()->profile['gross_tonnage'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
                <li class="profile-list__item">
                  <span class="profile-list__label">Net Tonnage</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="net_tonnage" value="{{ old('net_tonnage', auth()->user()->profile['net_tonnage'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
                <li class="profile-list__item">
                  <span class="profile-list__label">Dead Weight</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="dead_weight" value="{{ old('dead_weight', auth()->user()->profile['dead_weight'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
                <li class="profile-list__item">
                  <span class="profile-list__label">Engine Make</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="engine_make" value="{{ old('engine_make', auth()->user()->profile['engine_make'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
                <li class="profile-list__item">
                  <span class="profile-list__label">Serial Number</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="serial_number" value="{{ old('serial_number', auth()->user()->profile['serial_number'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
                <li class="profile-list__item">
                  <span class="profile-list__label">Horse Power</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="horse_power" value="{{ old('horse_power', auth()->user()->profile['horse_power'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
                <li class="profile-list__item">
                  <span class="profile-list__label">Speed</span>
                  <span class="profile-list__value">
                    <input class="profile-input" type="text" name="speed" value="{{ old('speed', auth()->user()->profile['speed'] ?? '') }}" style="width:100%; border:none; background:transparent; outline:none;" />
                  </span>
                </li>
              </ul>
            </section>
          </div>
        </div>

        <div class="profile-card__actions" style="margin-top: 1.25rem;">
          <button type="submit" class="btn-login btn-login--block">Save profile</button>
        </div>
      </div>
    </form>
  </main>
@endsection
