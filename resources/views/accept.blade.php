@extends('layouts.app')

@section('content')
  <div class="container">
    <div>
      <h1>Delete, edit or add messages in the group</h1>
      <a href="{{url('/messageEdit', ['id' => $group])}}">Edit</a>
    </div>
    <div class="flex-center position-ref full-height">
      <h1> Add new participant</h1>
      <form action="{{url('/addPersSub', ['id' => $group] )}}" method="post">
        {!! csrf_field() !!}
        <select class="form-control selectpicker" id="pers" name="pers[]" multiple>
          @foreach ($usersAdd as $userAdd)
            <option value="{{$userAdd->id}}">{{$userAdd->name}}</option>
          @endforeach
        </select>

        <button type="submit" class="btn btn-secondary">Add</button>
      </form>

      <h1> validation from request => </h1>
      <form action="{{url('/acceptVal', ['id' => $group] )}}" method="post">
        {!! csrf_field() !!}
        <select class="form-control selectpicker" id="users" name="users[]" multiple>

          @foreach ($users as $user)
            <option value="{{$user->id}}">{{$user->name}}</option>
          @endforeach
        </select>

        <button type="submit" class="btn btn-secondary">Validate</button>
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
                  <a class="btn btn-danger" href="{{url('ban', ['id' => $user->id, 'group' => $group])}}">Ban this participant by clicking here</a>
                @else
                    <a class="btn btn-secondary" href="{{url('unBanned', ['id' => $user->id, 'group' => $group])}}">Unban this participant by clicking here</a>
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
