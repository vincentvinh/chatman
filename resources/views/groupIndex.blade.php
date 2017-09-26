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
    <h1> New groupe ?</h1>
    <form action="/group" method="post">
      {!! csrf_field() !!}

      <div class="form-group">
        <label for="name">name</label>
        <textarea class="form-control" id="name" name="name" placeholder="name"></textarea>
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
    <div class="text-center">

      {{-- All the groups you are linked with => --}}
      @isset($groups)
        <h1>Group where you are involved<h1>
      @foreach ($groups as $group)
      <p>Name : <a href="group/{{$group->id}}"> {{$group->name}}</a></p>

    @endforeach

  @endisset

</div>
</div>
@endsection
