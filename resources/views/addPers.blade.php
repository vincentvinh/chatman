
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
              <h1> New participant</h1>
              <form action="{{url('/addPersSub', ['id' => $group->id] )}}" method="post">
                {!! csrf_field() !!}
                <select class="selectpicker" id="pers" name="pers[]" multiple>
                              @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                              @endforeach
                            </select>

                <button type="submit" class="btn btn-default">Submit</button>
              </form>

              </div>
            @endsection
