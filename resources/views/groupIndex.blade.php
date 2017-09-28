@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-xl-12">
        <div class="row">
          <div class="col col-xl-6">
            <h1> Group your are involved with</h1>
            @isset($groups)
              @foreach ($groups as $group)
                <a href="group/{{$group->id}}">
                  <div class="row">
                    <div class="col col-xs-3">
                    </div>

                    <div class="col col-xs-6 alert alert-success">
                      <h1 class="text-center"> {{$group->name}}</h1>
                    </div>
                    <div class="col col-xs-3">
                    </div>
                  </div>
                </a>
              @endforeach
            @endisset
          </div>
          <div class="col col-xl-6">

            <h1> Make a new groupe</h1>
            <form action="/group" method="post">
              {!! csrf_field() !!}

              <div class="form-group">
                <label for="name">name</label>
                <textarea class="form-control" id="name" name="name" placeholder="name"></textarea>
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
