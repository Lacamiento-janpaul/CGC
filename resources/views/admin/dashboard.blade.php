@extends('layouts.admin')

@section('title', 'Admin Dashboard — Boat Tracker')

@section('content')
  <main class="dashboard-main">
    <h1 class="dashboard-main__title">Admin Dashboard</h1>

    <div class="dashboard__grid">
      <!-- Real Time Tracker -->
      <section class="dashboard-tracker" aria-labelledby="tracker-heading">
        <h2 id="tracker-heading" class="dashboard-tracker__heading">Real Time Tracker</h2>
        <div class="dashboard-map-frame">
          <iframe
            title="Real-time map — Aparri region"
            width="500"
            height="300"
            allow="geolocation; fullscreen"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            src="https://api.maptiler.com/maps/019d5db8-3450-76ac-a846-377bc602ddf7/?key=cKkxa2xOPAnxlxvKPPjX#7.6/18.52817/122.67634"
          ></iframe>
        </div>

        <div class="dashboard-tracker__bottom">
          <div class="dashboard-search-block">
            <label for="boat-location-search">Search Boat by Security Number:</label>
            <div class="dashboard-search-row">
              <input type="search" id="boat-location-search" name="boat_location" placeholder="Enter security number…" autocomplete="off" />
              <button type="button" class="dashboard-icon-btn" aria-label="Search">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <circle cx="11" cy="11" r="7" />
                  <path d="M21 21l-4.35-4.35" />
                </svg>
              </button>
            </div>
            <div class="dashboard-boat-info" aria-label="Boat information">
              <div class="dashboard-boat-info__title">Boat information</div>
              <div id="boat-info-content" class="dashboard-boat-info__content">Owner and security number will appear here.</div>
            </div>
          </div>
          <div class="dashboard-result">
            <h3>Result</h3>
            <div class="dashboard-result__map">
              <iframe
                title="Boat location preview"
                width="260"
                height="260"
                allow="geolocation; fullscreen"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                src="https://api.maptiler.com/maps/019d5db8-3450-76ac-a846-377bc602ddf7/?key=cKkxa2xOPAnxlxvKPPjX#14/18.3547/121.6556"
              ></iframe>
            </div>
            <p>Boat location based from Lora.</p>
          </div>
        </div>
      </section>

      <!-- Boat management -->
      <section class="dashboard-boats" aria-labelledby="boats-heading">
        <h2 id="boats-heading" class="visually-hidden">Boat management</h2>
        <div class="dashboard-boats__toolbar">
          <div class="user-history__search-bar">
            <div class="user-history__search-input-wrap">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#757575" stroke-width="2" aria-hidden="true">
                <circle cx="11" cy="11" r="7" />
                <path d="M21 21l-4.35-4.35" />
              </svg>
              <input type="search" id="boat-table-search" placeholder="Search boats…" autocomplete="off" class="user-history__search-input" />
            </div>
            <button type="button" class="user-history__search-btn" aria-label="Search">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <circle cx="11" cy="11" r="7" />
                <path d="M21 21l-4.35-4.35" />
              </svg>
            </button>
          </div>
        </div>

        <div class="dashboard-table-wrap">
          <table class="dashboard-table">
            <thead>
              <tr>
                <th>Security Number</th>
                <th>Status</th>
                <th>current Location</th>
                <th>destination</th>
                <th>Captain</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
                @php
                  $latest = $user->latest_status ?? null;
                  $securityNumber = $latest['security_number'] ?? ($user->profile['security_number'] ?? '—');
                  $ownerName = $user->name ?? $user->username;
                  $ownerEmail = $user->email ?? '—';
                  $ownerContact = $user->profile['contact_number'] ?? $user->profile['emergency_contact_number'] ?? '—';
                  $ownerAddress = $user->profile['residential_address'] ?? $user->profile['business_address'] ?? '—';
                @endphp
                <tr
                  data-owner-name="{{ e($ownerName) }}"
                  data-owner-email="{{ e($ownerEmail) }}"
                  data-owner-contact="{{ e($ownerContact) }}"
                  data-owner-address="{{ e($ownerAddress) }}"
                  data-boat-security="{{ e($securityNumber) }}"
                  data-boat-history="{{ e($user->history_text ?? '') }}"
                >
                  <td>{{ $securityNumber }}</td>
                  <td>{{ $latest['status'] ?? '—' }}</td>
                  <td>{{ $latest['current_location'] ?? '—' }}</td>
                  <td>{{ $latest['destination'] ?? '—' }}</td>
                  <td>{{ $ownerName }}</td>
                  <td>
                    <div class="dashboard-table__actions">
                      <a href="{{ route('admin.user.history', ['id' => $user->id]) }}" class="dashboard-btn">History</a>
                      <a class="dashboard-btn" href="{{ route('admin.user.profile', ['id' => $user->id]) }}">Visit profile</a>
                    </div>
                  </td>
                </tr>
                @foreach($user->history_entries as $historyEntry)
                  @php
                    $historySearch = trim(implode(' ', [
                      $historyEntry['security_number'] ?? '',
                      $historyEntry['date'] ?? '',
                      $historyEntry['time'] ?? '',
                      $historyEntry['current_location'] ?? '',
                      $historyEntry['destination'] ?? '',
                      $historyEntry['status'] ?? '',
                    ]));
                  @endphp
                  <tr class="dashboard-table__history-row" data-parent-user="{{ $user->id }}" data-history-search="{{ e($historySearch) }}" style="display:none; background: #f5f8ff; color:#333;">
                    <td>{{ $historyEntry['security_number'] ?? '—' }}</td>
                    <td>{{ $historyEntry['status'] ?? '—' }}</td>
                    <td>{{ $historyEntry['current_location'] ?? '—' }}</td>
                    <td>{{ $historyEntry['destination'] ?? '—' }}</td>
                    <td colspan="2" style="font-size:0.9rem; color:#555;">History entry &ndash; {{ $historyEntry['date'] ?? '—' }} {{ $historyEntry['time'] ?? '' }}</td>
                  </tr>
                @endforeach
              @empty
                <tr>
                  <td colspan="6" style="text-align:center; padding:1.5rem 0; color:#666;">No users found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </section>

      <!-- Emergency -->
      <section class="dashboard-emergency" aria-labelledby="emergency-heading">
        @php $hasQueuedAlerts = isset($reports) && $reports->isNotEmpty(); @endphp
        <div class="dashboard-emergency__header">
          <div>
            <h2 id="emergency-heading" class="dashboard-emergency__title">Emergency</h2>
          </div>
          <div class="dashboard-emergency__header-actions">
            <button type="button" class="dashboard-emergency__button" id="alert-queue-button">{{ $hasQueuedAlerts ? 'Hide queue' : 'Alert queue' }}</button>
            <a href="{{ route('admin.emergency.history') }}" class="dashboard-emergency__badge dashboard-emergency__badge--link">History</a>
          </div>
        </div>

        <div id="alert-queue-placeholder" class="dashboard-emergency__placeholder" style="display: {{ $hasQueuedAlerts ? 'none' : 'block' }};">
          Click "Alert queue" to show the list of queued emergencies.
        </div>

        @if($hasQueuedAlerts)
          <div class="dashboard-emergency__cards">
            @foreach($reports as $index => $item)
              <div class="dashboard-emergency__card {{ strtolower($item['report']['emergency_type']) === 'extreme' ? 'dashboard-emergency__card--extreme' : '' }}" data-user-id="{{ $item['user']->id }}" data-index="{{ $index }}">
                <div class="dashboard-emergency__card-head">
                  <span class="dashboard-emergency__type">{{ $item['report']['emergency_type'] }}</span>
                  <span class="dashboard-emergency__severity">{{ $item['report']['emergency_type'] === 'Extreme' ? 'High priority' : 'Low priority' }}</span>
                </div>
                <p class="dashboard-emergency__message">{{ $item['report']['message'] ?? 'No description provided.' }}</p>
                <div class="dashboard-emergency__meta">
                  <span><strong>User</strong> {{ $item['user']->name ?? $item['user']->username }}</span>
                  <span><strong>Location</strong> {{ $item['report']['location'] ?? 'Unknown' }}</span>
                  <span><strong>Submitted</strong> {{ isset($item['report']['submitted_at']) ? \Carbon\Carbon::parse($item['report']['submitted_at'])->format('M j, Y g:i A') : 'Unknown' }}</span>
                </div>
                <button type="button" class="dashboard-emergency__response-btn" data-user-id="{{ $item['user']->id }}" data-index="{{ $index }}">Respond</button>
              </div>
            @endforeach
          </div>
        @else
          <div class="dashboard-emergency__cards dashboard-emergency__cards--hidden">
            <div class="dashboard-emergency__card dashboard-emergency__card--empty">No emergency reports yet.</div>
          </div>
        @endif
      </section>
    </div>

    <!-- Emergency Response Modal -->
    <div id="emergency-modal" class="modal" style="display: none;">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Respond to Emergency</h3>
          <button type="button" class="modal-close">&times;</button>
        </div>
        <form id="emergency-response-form" method="post">
          @csrf
          <div class="modal-body">
            <p id="modal-description"></p>
            <textarea name="response" id="response-text" placeholder="Type your acknowledgment or action here..." required></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="modal-cancel">Cancel</button>
            <button type="submit" class="modal-submit">Submit Response</button>
          </div>
        </form>
      </div>
    </div>
  </main>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('emergency-modal');
        const form = document.getElementById('emergency-response-form');
        const closeBtn = document.querySelector('.modal-close');
        const cancelBtn = document.querySelector('.modal-cancel');
        const responseBtns = document.querySelectorAll('.dashboard-emergency__response-btn');

        responseBtns.forEach(btn => {
          btn.addEventListener('click', function () {
            const userId = this.getAttribute('data-user-id');
            const index = this.getAttribute('data-index');
            const card = this.closest('.dashboard-emergency__card');
            const message = card.querySelector('.dashboard-emergency__message').textContent;
            const user = card.querySelector('.dashboard-emergency__meta span:first-child').textContent.replace('User ', '');

            document.getElementById('modal-description').textContent = `Responding to emergency from ${user}: "${message}"`;
            form.action = `/admin/emergency/${userId}/${index}/respond`;
            modal.style.display = 'block';
          });
        });

        closeBtn.addEventListener('click', () => modal.style.display = 'none');
        cancelBtn.addEventListener('click', () => modal.style.display = 'none');

        window.addEventListener('click', (e) => {
          if (e.target === modal) {
            modal.style.display = 'none';
          }
        });

        const alertQueueButton = document.getElementById('alert-queue-button');
        const alertQueuePlaceholder = document.getElementById('alert-queue-placeholder');
        const alertQueueCards = document.querySelector('.dashboard-emergency__cards');
        const trackerSearchInput = document.getElementById('boat-location-search');
        const tableSearchInput = document.getElementById('boat-table-search');
        const boatInfoContent = document.getElementById('boat-info-content');
        const mainRows = Array.from(document.querySelectorAll('.dashboard-table tbody tr:not(.dashboard-table__history-row)'));
        const historyRows = Array.from(document.querySelectorAll('.dashboard-table__history-row'));
        const searchInputs = [trackerSearchInput, tableSearchInput].filter(Boolean);

        function updateBoatInfo() {
          const firstVisible = mainRows.find(row => row.style.display !== 'none');
          if (firstVisible) {
            const owner = firstVisible.dataset.ownerName || 'Unknown owner';
            const email = firstVisible.dataset.ownerEmail || '—';
            const contact = firstVisible.dataset.ownerContact || '—';
            const address = firstVisible.dataset.ownerAddress || '—';
            const security = firstVisible.dataset.boatSecurity || 'Unknown';
            boatInfoContent.innerHTML = `
              <strong>${owner}</strong><br>
              Security number: ${security}<br>
              Email: ${email}<br>
              Contact: ${contact}<br>
              Address: ${address}
            `;
          } else {
            boatInfoContent.textContent = 'No matching security number found.';
          }
        }

        function filterBoatTable(query) {
          const normalizedQuery = query.trim().toLowerCase();

          mainRows.forEach(row => {
            const rowText = (row.textContent + ' ' + (row.dataset.boatHistory || '')).trim().toLowerCase();
            const matches = normalizedQuery === '' || rowText.includes(normalizedQuery);
            row.style.display = matches ? '' : 'none';
          });

          historyRows.forEach(row => {
            const matches = normalizedQuery !== '' && row.dataset.historySearch.toLowerCase().includes(normalizedQuery);
            row.style.display = matches ? '' : 'none';
          });

          updateBoatInfo();
        }

        function syncSearchInputs(sourceInput) {
          const value = sourceInput.value || '';
          searchInputs.forEach(input => {
            if (input !== sourceInput && input.value !== value) {
              input.value = value;
            }
          });
        }

        if (searchInputs.length > 0 && mainRows.length > 0) {
          searchInputs.forEach(input => {
            input.addEventListener('input', function () {
              syncSearchInputs(this);
              filterBoatTable(this.value);
            });
          });
          filterBoatTable('');
        }

        const searchButtons = Array.from(document.querySelectorAll('.dashboard-search-row button, .user-history__search-btn'));
        if (searchButtons.length > 0) {
          searchButtons.forEach(button => {
            button.addEventListener('click', function (event) {
              event.preventDefault();
              const input = this.closest('.dashboard-search-row')?.querySelector('input[type="search"]') || trackerSearchInput || tableSearchInput;
              if (input) {
                input.focus();
                syncSearchInputs(input);
                filterBoatTable(input.value);
              }
            });
          });
        }

        if (alertQueueButton && alertQueuePlaceholder && alertQueueCards) {
          alertQueueButton.addEventListener('click', function () {
            const isHidden = alertQueueCards.classList.toggle('dashboard-emergency__cards--hidden');
            alertQueuePlaceholder.style.display = isHidden ? 'block' : 'none';
            this.textContent = isHidden ? 'Alert queue' : 'Hide queue';
          });
        }
      });
    </script>
  @endpush
@endsection
