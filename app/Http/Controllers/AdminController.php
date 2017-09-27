<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

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
    public function accept($request)
    {
        $userId = $request->user()->id;
        $users = \App\User::select('users.id', 'users.name')
                            ->join('group_user', 'user.id', '=', 'group_user.user_id')
                            ->join('groups', 'group_user.group_id', '=', 'groups.id' )
                            ->addselect('groups.id')
                            ->where('groups.owner', $userId)
                            ->andwhere('group_user.approved', 0)
                            ->get();


      return view('accept', [
        'users' => $users]);

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
        //
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
