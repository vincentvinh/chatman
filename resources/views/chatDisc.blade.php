@extends('layouts.app')

@section('content')
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
          <h1> Here are the participants :
{{-- {{dump($group->users)}} --}}
            @foreach ($group->users as $user)
              <p>Mr {{$user->name}}</p> and

            @endforeach
            @foreach ($messages as $message)

              <p>Writer : {{$message->user->name }} </br>
                Content : {{$message->content}}</a></p>
              @endforeach

            @endisset

          </div>
        </div>
      @endsection
