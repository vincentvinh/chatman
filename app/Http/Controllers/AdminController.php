<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use Validator;
use DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    $userId = $request->user()->id;
        $groupsOwned = \App\Group::select('groups.id', 'groups.name')
                                  ->where('groups.owner', $userId)
                                  ->get();

            return view('admin', [
              'groupsOwned' => $groupsOwned]);

    }
    public function accept(Request $request, $id)
    {
        $group = \App\Group::find($id);
        $groupId = $group->id;
        $tab='';
        // dd( $group);
        $userReal = $request->user();
        $userId = $request->user()->id;
        $array =  $group->users;
        foreach ($array as $value) {
          $idea[] = $value->id;
        }

        ////////////////////////////////////////////////////////////////////////////////
        $arrayUsers = \App\User::where('users.id', '!=', $userId)->get();

        foreach ($arrayUsers as $papa) {

          if(in_array($papa->id, $idea))
          {
            $tab[] = $papa->id;
          }
        }

        foreach ($group->users as $userAdd1) {

        $usersAdd = \App\User::join('group_user', 'group_user.user_id', '=', 'users.id')
                                ->where('group_user.user_id', '=', $userAdd1->id)
                                ->where('group_user.status', '=', 1)
                                ->get();

          if (!empty($usersAdd[0])) {

            if (in_array($usersAdd[0]->id, $tab)) {

              if(($key = array_search($usersAdd[0]->id, $tab)) !== false) {
                    unset($tab[$key]);
              }

            }
            else {
              // $tab[] = $usersAdd[0]->id;
            }

          }
        }
        foreach ($tab as $trop) {
          $bon[] = \App\User::find($trop);
        }


        ////////////////////////////////////////////////////////////////////////////////

        ////////////////////////////////////////////////////////////////////////////////
        $users = \App\User::select('users.id', 'users.name')
                            ->join('group_user', 'group_user.user_id', '=', 'users.id')
                            ->where('group_user.group_id', $group->id)
                            ->where('group_user.user_id', '!=', $userId)
                            ->whereNotNull('group_user.status')
                            ->where('group_user.status', '!=', 1)
                            ->get();
        ////////////////////////////////////////////////////////////////////////////////
        $allusers = \App\User::join('group_user', 'group_user.user_id', '=', 'users.id')
                            ->where('group_user.group_id', $group->id)
                            ->where('group_user.user_id', '!=', $userId)
                            ->where('group_user.status', '>=', 1)
                            ->get();


      return view('accept', [
        'users' => $users, 'group' =>$group, 'allusers' => $allusers,'usersAdd' => $bon]);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function acceptVal(Request $request, $id)
    {


            $validator = Validator::make($request->all(), [
              'users' => 'required',

            ]);
            if ($validator->fails()) {
              return back()
              ->withInput()
              ->withErrors($validator);
            }
            else {

              $group = \App\Group::find($id);
// dd($request->users);
              foreach ($request->users as $userId) {


              DB::table('groups')->join('group_user', 'group_user.group_id', '=', 'groups.id')
                                  ->where('group_user.user_id', '=', $userId)
                                  ->where('group_user.group_id', '=', $group->id)
                                  ->update(['status' => '1']);

                                }
              }

    return redirect()->route('accept', [
      'group' => $group->id]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ban(Request $request, $id, $group)
    {
      DB::table('groups')->join('group_user', 'group_user.group_id', '=', 'groups.id')
                          ->where('group_user.user_id', '=', $id)
                          ->where('group_user.group_id', '=', $group)
                          ->update(['status' => '2']);

                          return redirect()->route('accept', [
                            'group' => $group]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
