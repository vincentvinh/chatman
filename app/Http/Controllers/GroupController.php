<?php

namespace App\Http\Controllers;

use App\Group;
use App\Message;
use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
use App\MessagePhotos;
use App\User;
use \Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(Request $request)
  {
    $userId = $request->user()->id;

    $groups = \App\Group::select('groups.id', 'groups.name')
    ->join('group_user', 'group_user.group_id', '=', 'groups.id')
    ->join('users', 'group_user.user_id', '=', 'users.id')
    ->where('group_user.user_id', $userId)
    ->where('group_user.status', 1)
    ->get();


    return view('groupIndex', [
      'groups' => $groups,
    ]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|max:255',
    ]);
    if ($validator->fails()) {
      return back()
      ->withInput()
      ->withErrors($validator);
    }
    else {
      // On recup l'utilisateur pour que le projet soit asocié à l'utilisateur
      $user = $request->user();
      $group = new \App\Group();
      $group->owner = $user->id;
      $group->name = $request->name;


      $group->save();
      // $userReal = $user->groups()->attach($group->id);
      $group->users()->attach($user->id,['status' => '1']);

      return redirect()->route('group');
    }

  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Group  $group
  * @return \Illuminate\Http\Response
  */
  public function show(Request $request, $id)
  {
    $messages = \App\Message::leftjoin('group_message', 'group_message.message_id', '=', 'messages.id')

                              ->where('group_message.group_id', $id)
                              ->orderBy('messages.created_at', 'desc')
                              ->get();



    $group = \App\Group::find($id);

    $userId = $request->user()->id;

    return view('chatDisc', [
      'messages' => $messages,
      'group' => $group
    ]);
  }
  public function storeMsg(Request $request, $group)
  {

    // dd($files);

    $validator = Validator::make($request->all(), [
      'content' => 'required|max:255',
      'name' => 'required',
      'photos' => 'array'
    ]);
    if ($validator->fails()) {
      return back()
      ->withInput()
      ->withErrors($validator);
    }
    else {
      // On recup l'utilisateur pour que le projet soit asocié à l'utilisateur
      $user = $request->user();
      $group = \App\Group::find($group);
      $message = new \App\Message();
      $message->content = $request->content;
      $message->name = $request->name;
      $message->user_id = $user->id;
      $message->save();
      // $userReal = $user->groups()->attach($group->id);

      //we get all the images in the directory and check if the one we want to upload doesnt exist allready
      $files = Storage::allFiles('public/photos/');

      if (!empty($files))
      {
        foreach ($files as $fileCheck) {
              // dump($fileCheck);
          $tabCheck[] = str_replace("public/photos/", "", $fileCheck);

        }
        // dd( $tabCheck);
      }

      if (!empty($request->photos)) {
        foreach ($request->photos as $photo) {

          //we get all the photos file and foreach photo we check
          $filename = $photo->getClientOriginalName();
          if(in_array($filename, $tabCheck))
          {
            //We dont need to store the image but we need to create a object
            $messagePhotos = new \App\MessagePhotos;
            $messagePhotos->message_id = $message->id;
            $messagePhotos->filename = $filename;
            $messagePhotos->save();

          }
          else {

            $path = $photo->storeAs('public/photos', $filename);
            $messagePhotos = new \App\MessagePhotos;
            $messagePhotos->message_id = $message->id;
            $messagePhotos->filename = $filename;
            $messagePhotos->save();
          }

        }
      }

      $message->groups()->attach($group->id);
      // dd($message);
      return redirect()->route('groupMsg', ['name' => $group->id]);
    }

  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Group  $group
  * @return \Illuminate\Http\Response
  */
  public function addPers(Request $request, $id)
  {

    $user = $request->user()->id;
    $users = \App\User::where('users.id', '!=', $user )->get();
    $group = \App\Group::find($id);

    return view( 'addPers',
    ['group' => $group, 'users' => $users]
  );

}
public function addMe(Request $request, $id)
{

  $user = $request->user()->id;

  $group = \App\Group::find($id);

  // I have add the user to the group and set the approved on group_user at 0

  $group->users()->attach($user, ['status' => 0]); //I add the user to the group and set on 0 the approved values

  return redirect( 'home');

}

/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  \App\Group  $group
* @return \Illuminate\Http\Response
*/
public function addPersSub(Request $request, $id)
{

  $validator = Validator::make($request->all(), [
    'pers' => 'required',

  ]);
  if ($validator->fails()) {
    return back()
    ->withInput()
    ->withErrors($validator);
  }
  else {
    $group = \App\Group::find($id);

    $userExists = $group->users;
    //
    foreach ($userExists as $userExist) {
    $uu[] = $userExist->id;      # code...
    }
    //We have to check first if  the user is allready in the database
    //If it is we update
    //not we create
    ///////////////////////////////////////////////////////////////

    foreach ($request->pers as $per) {

      if (in_array($per, $uu)) {
        $user = DB::table('users')->where('id', $per)
        ->join('group_user', 'group_user.user_id', '=', 'users.id')
        ->update(['status' => 3]);
      }
      else {

        $group->users()->attach($per, ['status' => 3]);
      }


    }
  }
  // dd( $group);
  return redirect()->route('accept',
  ['id' => $id]
);
}

/**
* Remove the specified resource from storage.
*
* @param  \App\Group  $group
* @return \Illuminate\Http\Response
*/

}
