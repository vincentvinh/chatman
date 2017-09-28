@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Dashboard</div>

          <div class="panel-body">
            @if (session('status'))
              <div class="alert alert-success">
                {{ session('status') }}
              </div>
            @endif

            You are logged in!
            <h1>Add your self to one of these groups and wait for the admin acceptation</h1>
            @auth
              @isset($groups)

                @foreach ($groups as $group)
                  {{-- {{dump($group)}} --}}

                    <!-- Trigger the modal with a button -->
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal{{$group->id}}"> {{$group->name}}</button>

                    <!-- Modal -->
                    <div id="myModal{{$group->id}}" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{$group->name}}</h4>
                          </div>
                          <div class="modal-body">
                            <p>Some text in the modal.</p>
                          </div>
                          <div class="modal-footer">
                            <a href="{{url('/addMe', ['id' => $group->id])}}"><button type="button" class="btn btn-default">Join the group</button></a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                    </div>



                @endforeach
              @endisset

            @endauth

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
