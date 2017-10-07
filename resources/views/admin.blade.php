@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="flex-center position-ref full-height">
      @if (Route::has('login'))
        <div class="top-right links">
          @auth


          @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
          @endauth
        </div>
      @endif
    </div>

    <h1> Here are all your groups :</h1>

    @foreach ($groupsOwned as $group)
      <a class="" href="{{url('/accept', ['id' =>$group->id])}}">
        <div class="row">
          <div class="col col-xs-3">
          </div>

          <div class="col col-xs-6 alert alert-success">
            <p class="text-center">Mr {{$group->name}}</p>
          </div>
          <div class="col col-xs-3">
          </div>
        </div>
      </a>
      @endforeach




    </div>


  @endsection
