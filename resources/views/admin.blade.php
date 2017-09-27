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


      <h1> Here are all your groups :

         @foreach ($groupsOwned as $group)

              <a href="{{url('/accept', ['id' =>$group->id])}}"><p class="text-center">Mr {{$group->name}}</p></a>
           {{-- @foreach ($group->users() as $user)

               <p class="text-center">Mr {{$user->name}}</p>

           @endforeach --}}


        @endforeach




      </div>
    </div>
  </div>
@endsection
