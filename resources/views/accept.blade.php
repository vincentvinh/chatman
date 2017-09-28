@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="flex-center position-ref full-height">
      <h1> Add new participant</h1>
      <form action="{{url('/addPersSub', ['id' => $group] )}}" method="post">
        {!! csrf_field() !!}
        <select class="selectpicker" id="pers" name="pers[]" multiple>
          @foreach ($usersAdd as $userAdd)
            <option value="{{$userAdd->id}}">{{$userAdd->name}}</option>
          @endforeach
        </select>
        
        <button type="submit" class="btn btn-default">Submit</button>
      </form>

      <h1> New participant validation for your group => {{$group->name}}</h1>
      <form action="{{url('/acceptVal', ['id' => $group] )}}" method="post">
        {!! csrf_field() !!}
        <select class="selectpicker" id="users" name="users[]" multiple>
          @foreach ($users as $user)
            <option value="{{$user->id}}">{{$user->name}}</option>
          @endforeach
        </select>

        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <div class="row">
        {{-- d{{dump($allusers)}} --}}
        <div class="col col-xl-12">
          <h2>All the participant in the group =></h2>


          @foreach ($allusers as $user)
            <div class="row">
              <div class="col col-xs-4">
                {{$user->name}}
              </div>
              <div class="col col-xs-4">
                {{$user->status}}
              </div>
              <div class="col col-xs-4">
                @if($user->status == 1)
                  <a href="{{url('ban', ['id' => $user->id, 'group' => $group])}}"><button>Ban this participant by clicking here</button></a>
                @else
                  <p> this participant is banned</p>
                @endif
              </div>
            </div>

          @endforeach
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
