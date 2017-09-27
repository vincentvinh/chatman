@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="flex-center position-ref full-height">
      @if (Route::has('login'))
        <div class="top-right links">
          @auth
            <a href="{{ url('/home') }}">Home</a></br>

          @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
          @endauth
        </div>
      @endif

      {{dump($groupsOwned)}}
      <h1> Here are all your groups :
        {{-- {{dump($group->users)}} --}}
        {{-- @foreach ($users as $user)
          <p class="text-center">Mr {{$user->name}}</p>

        @endforeach --}}




      </div>
    </div>
  </div>
@endsection
