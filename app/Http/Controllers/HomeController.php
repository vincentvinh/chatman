<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use DB;

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
      $array = [];
      // dd($request->user());
      if(empty($request->user()->id))
      {
        return view('home');
      }else {
        $userId = $request->user()->id;

        $groups = \App\Group::All();

        foreach ($groups as $group) {
          if ($group->owner !== $userId)  {

                foreach ($group->users as $user) {
                  if ($user->id !== $userId) {


                  }
                  else {
                    $groups = \App\Group::select('groups.id', 'groups.name')
                                        ->join('group_user', 'group_user.group_id', '=', 'groups.id')
                                        ->where('group_user.group_id', $group->id)
                                        ->where('group_user.user_id', '=', $userId)
                                        ->where('group_user.status', '=', 0)
                                        ->get();
                    if(empty($groups))
                    {
                        $array[] = $group;
                    }

                  }

                }
          }
        }



        // dd( $array);
        // //Add all the groups where you can add yourself
        // $groups = DB::table('groups')->select('groups.id', 'groups.name')
        //                     ->groupBy('groups.id')
        //                     //all the group owned by somebodyelse
        //                     ->where('groups.owner', '!=', $userId)
        //                     //and where I dont take part off
        //                     ->join('group_user', 'group_user.group_id', '=', 'groups.id')
        //                     ->Where('group_user.user_id', '=', $userId)
        //                     ->where('group_user.group_id', '=', )
        //                     ->get();
        //                     dd($groups);
        //                     if (emptyArray($groups)) {
        //
        //
        //                       $groups = DB::table('groups')->select('groups.id', 'groups.name')
        //                                           ->groupBy('groups.id')//all the group owned by somebodyelse
        //                                           ->where('groups.owner', '!=', $userId)
        //                                           //and where I dont take part off
        //                                           ->leftjoin('group_user', 'group_user.group_id', '=', 'groups.id')
        //                                           ->Where('group_user.user_id', '!=', $userId)
        //
        //                                           ->get();
        //                                           /
        //                     }



          return view('home',
          ['groups' => $array]
        );
      }
    }
}
