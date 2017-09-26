<?php

namespace App\Http\Controllers;

use App\Group;
use App\Message;
use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
use App\User;

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
                          ->get();
                          // dd($groups);

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

        $group->name = $request->name;


        $group->save();
// $userReal = $user->groups()->attach($group->id);
        $group->users()->attach($user->id);

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
      $messages = \App\Message::join('group_message', 'group_message.message_id', '=', 'messages.id')
                              ->join('groups', 'group_message.group_id', '=', 'groups.id' )
                              ->where('groups.id', $id)
                              ->orderBy('messages.created_at', 'desc')
                              ->get();
                              // dd($messages);


      $group = \App\Group::find($id);

      $userId = $request->user()->id;

            return view('chatDisc', [
              'messages' => $messages,
              'group' => $group
            ]);
    }
    public function storeMsg(Request $request, $group)
    {
// dd($group);
      $validator = Validator::make($request->all(), [
        'content' => 'required|max:255',

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
        $message->user_id = $user->id;
        $message->save();
// $userReal = $user->groups()->attach($group->id);



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
// dd($request);
  //     $validator = Validator::make($request->all(), [
  //       'pers' => 'required',
  //
  //     ]);
  //     if ($validator->fails()) {
  //       return back()
  //       ->withInput()
  //       ->withErrors($validator);
  //     }
  //     else {
  // dd($request);
  //       foreach ($request->pers as $pers) {
  //           dd($pers);
  //       }
  //     }
        return view( 'addPers',
        ['group' => $group, 'users' => $users]
      );

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

        foreach ($request->pers as $per) {
          $user = \App\User::find($per);
          // dd($user);
          $group->users()->attach($user);

        }
      }
      // dd( $group);
        return redirect()->route('groupMsg',
        ['id' => $id]
      );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }
}
