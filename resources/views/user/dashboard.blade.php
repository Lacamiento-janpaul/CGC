@extends('layouts.user')

@section('title', 'User Dashboard — Boat Tracker')

@section('content')
  <main class="user-dashboard">
    <div class="user-dashboard__container">
      <!-- Left Section: Status and History -->
      <div class="user-dashboard__left">
        <!-- Current Status -->
        <section class="user-status-section" aria-labelledby="status-heading">
          <h2 id="status-heading" class="user-section__title">CURRENT STATUS</h2>

          @if(session('status'))
            <div class="status-message">{{ session('status') }}</div>
          @endif
          @if(session('error'))
            <div class="status-message" style="color:#c72f2f; margin-bottom:1rem;">{{ session('error') }}</div>
          @endif
          @if(!($profileComplete ?? true))
            <div class="status-message" style="color:#994c00; margin-bottom:1rem;">
              Please complete your profile before submitting current status. <a href="{{ route('user.profile') }}">Update your profile</a>.
            </div>
          @endif

          <form method="post" action="{{ route('user.status.update') }}">
            @csrf
            <div class="user-status-table-wrap">
              <table class="user-status-table">
                <thead>
                  <tr>
                    <th>Security Number</th>
                    <th>DATE</th>
                    <th>TIME</th>
                    <th>current Location</th>
                    <th>destination</th>
                    <th>STATUS</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><input class="status-table__input" type="text" name="security_number" value="{{ old('security_number', $editing['security_number'] ?? auth()->user()->profile['security_number'] ?? '') }}" /></td>
                    <td><input id="status-date" class="status-table__input" type="date" name="date" value="{{ old('date', $editing['date'] ?? '') }}" /></td>
                    <td><input id="status-time" class="status-table__input" type="time" name="time" value="{{ old('time', $editing['time'] ?? '') }}" /></td>
                    <td><input id="status-location" class="status-table__input" type="text" name="current_location" value="{{ old('current_location', $editing['current_location'] ?? '--') }}" /></td>
                    <td><input class="status-table__input" type="text" name="destination" value="{{ old('destination', $editing['destination'] ?? '--') }}" /></td>
                    <td>
                      <select class="status-table__input" name="status">
                        @foreach(['ON PORT', 'AT SEA', 'DELAYED', 'OFF PORT'] as $option)
                          <option value="{{ $option }}" {{ old('status', $editing['status'] ?? 'ON PORT') === $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                      </select>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            @if(isset($editing['edit_index']))
              <input type="hidden" name="edit_index" value="{{ $editing['edit_index'] }}" />
            @endif

            <div style="display:flex; gap:0.75rem; flex-wrap:wrap; align-items:center; margin-top:1rem;">
              <button type="submit" class="user-status__submit-btn" {{ empty($profileComplete) ? 'disabled' : '' }}>{{ isset($editing['edit_index']) ? 'Update' : 'Submit' }}</button>
              @if(isset($editing['edit_index']))
                <a href="{{ route('user.dashboard') }}" class="user-status__cancel-link">Cancel</a>
              @endif
            </div>
          </form>
        </section>

        <!-- History -->
        <section class="user-history-section" aria-labelledby="history-heading">
          <h2 id="history-heading" class="user-section__title">History</h2>

          <div class="user-history__search-bar">
            <div class="user-history__search-input-wrap">
              <input type="search" id="boat-history-search" placeholder="Search history entries" autocomplete="off" class="user-history__search-input" />
              <button type="button" class="user-history__search-btn" aria-label="Search">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <circle cx="11" cy="11" r="7" />
                  <path d="M21 21l-4.35-4.35" />
                </svg>
              </button>
            </div>
          </div>

          <div class="user-history-table-wrap">
            @php $history = auth()->user()->profile['status_history'] ?? []; @endphp
            <table class="user-history-table">
              <thead>
                <tr>
                  <th>Boat Number</th>
                  <th>DATE</th>
                  <th>TIME</th>
                  <th>Previous Location</th>
                  <th>destination</th>
                  <th>STATUS</th>
                </tr>
              </thead>
              <tbody>
                @forelse($history as $index => $entry)
                  <tr>
                    <td>{{ $entry['security_number'] }}</td>
                    <td>{{ $entry['date'] ?? '—' }}</td>
                    <td>{{ $entry['time'] ?? '—' }}</td>
                    <td>{{ $entry['current_location'] ?? '—' }}</td>
                    <td>{{ $entry['destination'] ?? '—' }}</td>
                    <td>{{ $entry['status'] }}</td>
                    <td>
                      <a href="{{ route('user.dashboard', ['edit' => $index]) }}" class="user-history__action-link">Edit</a>
                      <form method="post" action="{{ route('user.status.delete', ['index' => $index]) }}" style="display:inline-block; margin-left: 0.5rem;">
                        @csrf
                        <button type="submit" class="user-history__action-delete">Delete</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" style="text-align:center; padding: 1.5rem 0; color: #666;">No history entries yet.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </section>

        <!-- GPS Tracker -->
        <section class="user-gps-section" aria-labelledby="gps-heading">
          <div class="user-gps__header">
            <h2 id="gps-heading" class="user-gps__title">GPS TRACKER</h2>
            <p class="user-gps__subtitle">CURRENT LOCATION</p>
          </div>

          <div class="user-gps__content">
            <div class="user-gps__map">
              <iframe
                title="Current GPS location — Apparri region"
                width="100%"
                height="200"
                allow="geolocation; fullscreen"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                src="https://api.maptiler.com/maps/019d5db8-3450-76ac-a846-377bc602ddf7/?key=cKkxa2xOPAnxlxvKPPjX#7.6/18.52817/122.67634"
              ></iframe>
            </div>

            <div class="user-gps__info">
              <ul class="user-gps__info-list">
                <li>
                  <span class="user-gps__label">current loc.</span>
                </li>
                <li>
                  <span class="user-gps__label">boat status</span>
                </li>
                <li>
                  <span class="user-gps__label">board no.</span>
                </li>
                <li>
                  <span class="user-gps__label">owner</span>
                </li>
              </ul>
            </div>
          </div>
        </section>
      </div>

      <!-- Right Section: Report -->
      <div class="user-dashboard__right">
        <!-- Report Form -->
        <section class="user-report-section" aria-labelledby="report-heading">
          <h2 id="report-heading" class="user-section__title">REPORT</h2>
          <div class="user-report__header-row">
            <p class="user-report__subtitle">report incident, emergency to PCG</p>
            <button type="button" id="toggle-admin-responses" class="user-report__toggle-btn" aria-expanded="false">Show admin responses</button>
          </div>

          <form class="user-report-form" method="post" action="{{ route('user.report.submit') }}">
            @csrf

            <div class="user-form-group">
              <label for="report-name">name:</label>
              <input type="text" id="report-name" name="name" placeholder="" value="{{ old('name', auth()->user()->name) }}" />
            </div>

            <div class="user-form-group">
              <label for="report-contact">Contact no.:</label>
              <input type="tel" id="report-contact" name="contact" placeholder="" value="{{ old('contact') }}" />
            </div>

            <div class="user-form-group">
              <label for="report-location">location:</label>
              <input type="text" id="report-location" name="location" placeholder="" value="{{ old('location') }}" />
            </div>

            <input type="hidden" id="report-date" name="report_date" value="{{ old('report_date') }}" />
            <input type="hidden" id="report-time" name="report_time" value="{{ old('report_time') }}" />

            <div class="user-form-group">
              <label for="report-type">emergency type:</label>
              <select id="report-type" name="emergency_type">
                <option value="Minor" {{ old('emergency_type') === 'Minor' ? 'selected' : '' }}>Minor</option>
                <option value="Extreme" {{ old('emergency_type') === 'Extreme' ? 'selected' : '' }}>Extreme</option>
              </select>
            </div>

            <div class="user-form-group user-form-group--large">
              <label for="report-message">message:</label>
              <textarea id="report-message" name="message" placeholder="">{{ old('message') }}</textarea>
            </div>

            <button type="submit" class="user-report__submit-btn">submit</button>
          </form>

          <div id="admin-responses-panel" class="user-report-notification" aria-live="polite" style="display:none;">
            <h3 class="user-report-notification__title">Admin response</h3>
            @if(isset($handledResponses) && $handledResponses->isNotEmpty())
              @foreach($handledResponses as $response)
                <div class="user-report-notification__card {{ ($response['emergency_type'] ?? '') === 'Extreme' ? 'user-report-notification__card--alert' : '' }}">
                  <div class="user-report-notification__meta">
                    <span class="user-report-notification__label">Type:</span>
                    <span>{{ $response['emergency_type'] ?? 'Emergency' }}</span>
                  </div>
                  <p class="user-report-notification__message">{{ $response['response'] }}</p>
                  <p class="user-report-notification__timestamp">Handled at {{ \Carbon\Carbon::parse($response['handled_at'])->format('M j, Y g:i A') }}</p>
                </div>
              @endforeach
            @else
              <p class="user-report-notification__empty">No admin responses yet.</p>
            @endif
          </div>
        </section>
      </div>
    </div>
  </main>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var searchInput = document.querySelector('#boat-history-search');
        var historyRows = document.querySelectorAll('.user-history-table tbody tr');

        if (!searchInput || historyRows.length === 0) {
          return;
        }

        function applyFilter() {
          var filterValue = searchInput.value.trim().toLowerCase();
          historyRows.forEach(function (row) {
            var cells = Array.from(row.querySelectorAll('td'));
            if (cells.length === 0) {
              return;
            }
            var rowText = cells.map(function (cell) {
              return cell.textContent.trim().toLowerCase();
            }).join(' ');
            row.style.display = filterValue === '' || rowText.includes(filterValue) ? '' : 'none';
          });
        }

        function pad(number) {
          return number < 10 ? '0' + number : number;
        }

        function setCurrentDateTime() {
          var now = new Date();
          var localDate = now.toISOString().slice(0, 10);
          var localTime = pad(now.getHours()) + ':' + pad(now.getMinutes());

          var statusDateInput = document.getElementById('status-date');
          var statusTimeInput = document.getElementById('status-time');
          var reportDateInput = document.getElementById('report-date');
          var reportTimeInput = document.getElementById('report-time');

          if (statusDateInput && !statusDateInput.value) {
            statusDateInput.value = localDate;
          }

          if (statusTimeInput && !statusTimeInput.value) {
            statusTimeInput.value = localTime;
          }

          if (reportDateInput && !reportDateInput.value) {
            reportDateInput.value = localDate;
          }

          if (reportTimeInput && !reportTimeInput.value) {
            reportTimeInput.value = localTime;
          }
        }

        function fillGeolocation() {
          if (!navigator.geolocation) {
            return;
          }

          navigator.geolocation.getCurrentPosition(function (position) {
            var coords = position.coords.latitude.toFixed(6) + ', ' + position.coords.longitude.toFixed(6);
            var statusLocationInput = document.getElementById('status-location');
            var reportLocationInput = document.getElementById('report-location');

            if (statusLocationInput && !statusLocationInput.value) {
              statusLocationInput.value = coords;
            }

            if (reportLocationInput && !reportLocationInput.value) {
              reportLocationInput.value = coords;
            }
          });
        }

        setCurrentDateTime();
        fillGeolocation();

        searchInput.addEventListener('input', applyFilter);
        searchInput.addEventListener('keydown', function (event) {
          if (event.key === 'Enter') {
            event.preventDefault();
          }
        });

        var toggleAdminResponsesButton = document.getElementById('toggle-admin-responses');
        var adminResponsesPanel = document.getElementById('admin-responses-panel');

        if (toggleAdminResponsesButton && adminResponsesPanel) {
          toggleAdminResponsesButton.addEventListener('click', function () {
            var isHidden = window.getComputedStyle(adminResponsesPanel).display === 'none';
            adminResponsesPanel.style.display = isHidden ? 'block' : 'none';
            toggleAdminResponsesButton.textContent = isHidden ? 'Hide admin responses' : 'Show admin responses';
            toggleAdminResponsesButton.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
          });
        }
      });
    </script>
  @endpush
@endsection
