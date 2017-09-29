<?php

namespace App\Http\Controllers;

use App\Message;
use App\MessagePhotos;
use App\Group;
use Illuminate\Http\Request;
use Validator;

use App\Http\Requests\UploadRequest;

class MessageController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {

    $messages = \App\Message::all();

    return view( 'submitMessage', ['messages', $messages]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function edit(Request $request, $id)
  {
    $group = \App\Group::find($id);

    $messages = \App\Message::join('group_message', 'group_message.message_id', '=', 'messages.id')
    ->where('group_message.group_id', $id)
    ->get();
    // dd( $messages);

    return view( 'editMessage', ['messages'=> $messages]);
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */


  public function store(UploadRequest $request)
  {

    $validator = Validator::make($request->all(), [
      'content' => 'required|max:255',
      'name' => 'required',
      'photos' => 'required'
    ]);
    if ($validator->fails()) {
      return back()
      ->withInput()
      ->withErrors($validator);
    }
    else {
      



      // On recup l'utilisateur pour que le projet soit associé à l'utilisateur
      $userId = $request->user()->id;
      $message = new \App\Message;
      $message->content = $request->content;
      $message->name = $request->name;
      $message->user_id = $userId;
      $message->save();
      foreach ($request->photos as $photo) {

        $filename = $photo->store('photos');

        $messagePhotos = new \App\MessagePhotos;
        $messagePhotos->message_id = $message->id;
        $messagePhotos->filename = $filename;
        $messagePhotos->save();
      }

      return redirect()->route('show');
    }


  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Message  $message
  * @return \Illuminate\Http\Response
  */
  public function show(Message $message)
  {
    $messages = \App\Message::All();

    // dd( $messages);
    return view( 'submitMessage', ['speMessage' => $message, 'messages' => $messages]);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Message  $message
  * @return \Illuminate\Http\Response
  */
  // public function edit(Message $message)
  // {
  //     //
  // }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Message  $message
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Message $message)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Message  $message
  * @return \Illuminate\Http\Response
  */
  public function destroy(Message $message)
  {
    //
  }
}
