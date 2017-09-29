@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-xl-12">
        <div class="panel panel-default">
          <div class="panel-heading">Dashboard</div>

          <div class="panel-body">
            @if (session('status'))
              <div class="alert alert-success">
                {{ session('status') }}
              </div>
            @endif
            <h1>Add your self to one of these groups and wait for the admin acceptation</h1>
            @auth
              @isset($groups)
                @foreach ($groups as $group)
                  {{-- {{dump($group)}} --}}
                  <div class="col col-xl-12">
                    <!-- Trigger the modal with a button -->
                    <div class="row">
                      <div class="col col-xl-12">
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
                      </div>
                    </div>
                  </div>
                @endforeach
              @endisset
              @foreach ($groupsWait as $groupWait)
                <div class="col col-xl-12">
                  <!-- Trigger the modal with a button -->
                  <div class="row">
                    <div class="col col-xl-12">
                      {{-- {{dump($groupWait->status)}} --}}
                      @if ($groupWait->status == 0)
                           <button type="button" class="btn btn-secondary btn-lg">  waiting for acceptation from the admin of {{$groupWait->name}}</button>
                        @else
                          <a href="{{url('joinGroup', ['id' => Auth::user()->id, 'group' => $groupWait->id])}}" class="btn btn-secondary">Click to join {{$groupWait->name}}</a>
                      @endif

                    </div>
                  </div>
                </div>
              @endforeach
            @endauth
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
