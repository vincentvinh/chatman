@extends('layouts.app')

@section('content')
  <div class="flex-center position-ref full-height">
    @if (Route::has('login'))
      <div class="top-right links">
        @auth
          <a href="{{ url('/home') }}">Home</a>
        @else
          <a href="{{ route('login') }}">Login</a>
          <a href="{{ route('register') }}">Register</a>
        @endauth
      </div>
    @endif

    <div class="content">
      <div class="title m-b-md">
        Laravel
      </div>

      <div class="links">
        <a href="/message">Ecrire un message</a>
        <a href="https://laracasts.com">Laracasts</a>
        <a href="https://laravel-news.com">News</a>
        <a href="https://forge.laravel.com">Forge</a>
        <a href="https://github.com/laravel/laravel">GitHub</a>
      </div>
    </div>
    @isset($speMessage)

      My message
      <h1> {{$speMessage->content}}</h1>
    @endisset

    <h1>Create a Message</h1>
    <form action="/message" method="post">
      {!! csrf_field() !!}

      <div class="form-group">
        <label for="content">Description</label>
        <textarea class="form-control" id="content" name="content" placeholder="content"></textarea>
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
    <div class="text-center">
      @isset($messages)
        @foreach ($messages as $message)

          @isset($message->user)
          <P>writer :  {{$message->user->name}}</P>
@endisset
          <p>content : {{$message->content}}</p>


        @endforeach

      @endisset

    </div>
  </div>
@endsection
