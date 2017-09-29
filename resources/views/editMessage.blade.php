@extends('layouts.app')

@section('content')


  <div class="container">
    <div class="row">


      @isset($messages)
        @foreach ($messages as $message)

          <div class="col col-xl-3 badge badge-pill badge-primary">   {{$message->user->name}} </div>

          @if ($message->user->id == Auth::user()->id)
            <div class="col col-xl-5">     {{$message->content}}</div>
          @else
            <div class="col col-xl-5 text-right">     {{$message->content}}</div>
          @endif

          {{-- Todo : allways the same date --}}
          <div class="col col-xl-2 text-right">      {{$message->created_at->format('d-m-Y H:i:s')}}</div>
          <div class="col col-xl-2 text-right">      <a href="">edit</a>, <a href="">delete</a></div>
        @endforeach

      @endisset

    </div>
  </div>

@endsection
