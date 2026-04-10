@extends('layouts.admin')

@section('title', 'Emergency History')

@section('content')
<main class="dashboard-main">
  <section class="dashboard-emergency">
    <div class="dashboard-emergency__header">
      <div>
        <h1 class="dashboard-main__title">Emergency History</h1>
        <p class="dashboard-emergency__subtitle">Review all handled emergency reports and responses</p>
      </div>
      <div class="dashboard-emergency__header-actions">
        <a href="{{ route('admin.dashboard') }}" class="dashboard-emergency__button dashboard-emergency__button--secondary">Back to dashboard</a>
        <div class="dashboard-emergency__badge">{{ count($handledReports) }} Handled</div>
      </div>
    </div>

    @if(count($handledReports) === 0)
      <div class="dashboard-emergency__card dashboard-emergency__card--empty">
        <p>No handled emergencies yet.</p>
      </div>
    @else
      <div class="dashboard-emergency__cards">
        @foreach($handledReports as $handledReport)
          @php
            $report = $handledReport['report'];
            $user = $handledReport['user'];
            $type = $report['emergency_type'] ?? 'Unknown';
            $severity = strtolower($type) === 'extreme' ? 'High priority' : 'Standard';
          @endphp

          <article class="dashboard-emergency__card {{ strtolower($type) === 'extreme' ? 'dashboard-emergency__card--extreme' : '' }}">
            <div class="dashboard-emergency__card-head">
              <span class="dashboard-emergency__type">{{ $type }}</span>
              <span class="dashboard-emergency__severity">{{ $severity }}</span>
            </div>

            <p class="dashboard-emergency__message">{{ $report['message'] ?? 'No description provided.' }}</p>

            <div class="dashboard-emergency__meta dashboard-emergency__meta--grid">
              <span><strong>User</strong> {{ $user->name ?? $user->username }}</span>
              <span><strong>Location</strong> {{ $report['location'] ?? 'Unknown' }}</span>
              <span><strong>Reported</strong> {{ isset($report['submitted_at']) ? \Carbon\Carbon::parse($report['submitted_at'])->format('M j, Y g:i A') : 'Unknown' }}</span>
              <span><strong>Handled</strong> {{ isset($report['handled_at']) ? \Carbon\Carbon::parse($report['handled_at'])->format('M j, Y g:i A') : 'Unknown' }}</span>
              <span class="dashboard-emergency__response-data"><strong>Response</strong> {{ $report['response'] ?? 'No response recorded' }}</span>
            </div>
          </article>
        @endforeach
      </div>
    @endif
  </section>
</main>
@endsection
