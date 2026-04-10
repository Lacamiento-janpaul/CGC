@extends('layouts.app')

@section('title', 'Aparri Philippine Coast Guard Boat Tracker')

@section('content')
  <main class="hero">
    <div class="hero-bg" aria-hidden="true"></div>
    <div class="hero-scrim" aria-hidden="true"></div>
    <div class="hero-card">
      <h1>Welcome to the Aparri Philippine Coast Guard Boat Tracker</h1>
      <p>
        The Aparri Philippine Coast Guard is dedicated to ensuring the safety and security of our maritime borders. Our
        mission is to protect lives, property, and the environment in our coastal areas.
      </p>
      <a class="btn-login" href="{{ route('login') }}">Login</a>
    </div>
  </main>
@endsection
