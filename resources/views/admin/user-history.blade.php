@extends('layouts.admin')

@section('title', 'User History — Boat Tracker')

@section('content')
  <main class="dashboard-main">
    <div style="margin-bottom: 1rem;">
      <a href="{{ route('admin.dashboard') }}" class="dashboard-btn">← Back to dashboard</a>
    </div>

    <section class="dashboard-boats" aria-labelledby="history-heading">
      <h2 id="history-heading" class="visually-hidden">User history</h2>
      <div class="dashboard-boats__toolbar" style="margin-bottom:1rem;">
        <div>
          <h1 class="dashboard-main__title">{{ $user->name ?? $user->username }}’s History</h1>
          <p style="margin-top: 0.5rem; color: #555;">Latest {{ count($history) }} entries from this user.</p>
        </div>
      </div>

      <div class="dashboard-table-wrap">
        <table class="dashboard-table">
          <thead>
            <tr>
              <th>Security Number</th>
              <th>DATE</th>
              <th>TIME</th>
              <th>Previous Location</th>
              <th>Destination</th>
              <th>STATUS</th>
              <th>Submitted</th>
            </tr>
          </thead>
          <tbody>
            @forelse($history as $entry)
              <tr>
                <td>{{ $entry['security_number'] ?? '—' }}</td>
                <td>{{ $entry['date'] ?? '—' }}</td>
                <td>{{ $entry['time'] ?? '—' }}</td>
                <td>{{ $entry['current_location'] ?? '—' }}</td>
                <td>{{ $entry['destination'] ?? '—' }}</td>
                <td>{{ $entry['status'] ?? '—' }}</td>
                <td>{{ $entry['submitted_at'] ?? '—' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="7" style="text-align:center; padding:1.5rem 0; color:#666;">No history entries available for this user.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>
  </main>
@endsection
