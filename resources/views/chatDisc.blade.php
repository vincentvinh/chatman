@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="flex-center position-ref full-height">
      @if (Route::has('login'))
        <div class="top-right links">
          @auth
            <a href="{{ url('/home') }}">Home</a></br>
            <a href="{{ url('/addPers', ['id' => $group->id])}}">Add a participant</a>
          @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
          @endauth
        </div>
      @endif

      {{-- {{dump($group)}} --}}
      <h1> Here are the participants :
        {{-- {{dump($group->users)}} --}}
        @foreach ($group->users as $user)
          <p class="text-center">Mr {{$user->name}}</p>

        @endforeach
      </div>
      <h1> New message</h1>
      <form action="{{url('/grMsg', ['id' => $group->id] )}}" method="post">
        {!! csrf_field() !!}

        <div class="form-group">
          <label for="content">content</label>
          <textarea class="form-control" id="content" name="content" placeholder="content"></textarea>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <div class="text-center">

        {{-- All the groups you are linked with => --}}
        @isset($messages)
          <h1>Messages in {{$group->name}}<h1>
          </div>
          <div class="row">
            @foreach ($messages as $message)

              <div class="col col-xs-3">   Writer : {{$message->user->name }} </div>

              <div class="col col-xs-5">     Content : {{$message->content}}</div>
              <div class="col col-xs-4">       Created : {{$message->created_at}}</div>

            @endforeach
          </div>
        @endisset


      </div>
    @endsection
