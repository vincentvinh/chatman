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

        @if (count($errors) > 0)
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
        @endif
        <form action="{{url('/grMsg', ['id' => $group->id] )}}" enctype="multipart/form-data" method="post">
          {!! csrf_field() !!}

          <div class="form-group">
            <label for="content">Description</label>
            <textarea class="form-control" id="content" name="content" placeholder="content"></textarea>
          </div>
          <div class="form-group">
            <label for="name">name</label>
            <textarea class="form-control" id="name" name="name" placeholder="name"></textarea>
          </div>
          <div class="form-group">
            <label for="photos">Photos</label>
            <input type="file" name="photos[]" multiple />
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
{{-- {{dump($message->photos)}} --}}
            <div class="col col-xl-3 badge badge-pill badge-primary">   {{$message->user->name}} </div>

            @if ($message->user->id == Auth::user()->id)
              <div class="col col-xl-4">     {{$message->content}}</div>
            @else
              <div class="col col-xl-4 text-right">     {{$message->content}}</div>
            @endif

            {{-- Todo : allways the same date --}}
        <div class="col col-xl-2 text-right">      {{$message->created_at->format('d-m-Y H:i:s')}}</div>

            @foreach ($message->photos as $photo)

              <div class="col col-xl-3 text-right">  <img alt="file" src="{{asset("storage/photos/$photo->filename")}}"></img></div>
            @endforeach

          @endforeach

        @endisset
      </div>
    </div>
  </div>
</div>

</div>





@endsection
