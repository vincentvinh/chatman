<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      // dd($request->user());
      if(empty($request->user()->id))
      {
        return view('home');
      }else {
        $userId = $request->user()->id;
        //Add all the groups where you can add yourself
        $groups = \App\Group::select('groups.id', 'groups.name')
                            //all the group owned by somebodyelse
                            ->where('groups.owner', '!=', $userId)
                            //and where I dont take part off
                            ->join('group_user', 'group_user.group_id', '=', 'groups.id')
                            ->where('group_user.approved', null)
                            //and where
                            ->join('users', 'group_user.user_id', '=', 'users.id')
                            ->get();

          return view('home',
          ['groups' => $groups]
        );
      }
    }
}
