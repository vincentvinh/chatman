@extends('layouts.app')

@section('content')

  <div class="container">

    <div class="row">

      <h3> Here are the participants :
        {{-- {{dump($group->users)}} --}}
        @foreach ($group->users as $user)
          @if($user->pivot->status == 1)
            <p class="badge badge-pill badge-secondary">{{$user->name}}</p>
          @endif


        @endforeach
      </div>

        <form action="{{url('/grMsg', ['id' => $group->id] )}}" method="post">
          {!! csrf_field() !!}

          <div class="form-group">

            <textarea class="form-control" id="content" name="content" placeholder="Write your own message ;-)"></textarea>
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>

      <div class="row">
        <div class="col col-xl-12">
          <div class="row">
            <div class="col col-xl-12 text-center">{{$group->name}}</div>
          </div>
        </div class="row">
        @isset($messages)


          @foreach ($messages as $message)

            <div class="col col-xl-3 badge badge-pill badge-primary">   {{$message->user->name}} </div>
            
            @if ($message->user->id == Auth::user()->id)
              <div class="col col-xl-5">     {{$message->content}}</div>
            @else
              <div class="col col-xl-5 text-right">     {{$message->content}}</div>
            @endif

            {{-- Todo : allways the same date --}}
            <div class="col col-xl-4 text-right">      {{$message->created_at->format('d-m-Y H:i:s')}}</div>

          @endforeach

        @endisset
      </div>
    </div>
  </div>
</div>

</div>





@endsection
