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


        <h1> New participant validation</h1>
        <form action="{{url('/acceptVal', ['id' => $group] )}}" method="post">
          {!! csrf_field() !!}
          <select class="selectpicker" id="users" name="users[]" multiple>
                        @foreach ($users as $user)
                              <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                      </select>

          <button type="submit" class="btn btn-default">Submit</button>
        </form>

      </div>
    </div>
  </div>
@endsection
