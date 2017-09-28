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


      if(empty($request->user()->id))
      {
        return view('home');

      }else {
      $tab = null;


        $userId = $request->user()->id;

        $groups = \App\Group::All();
// dd( $groups);
          foreach ($groups as $group) {



//Two different tasks 1 get the groups where an answer from the group owner is requestd
//2nd one All the groups where the user can apply


            //////////////////////////////////////////////////////////////////////

            $array = DB::table('groups')
                                ->join('group_user', 'group_user.group_id', '=', 'groups.id')
                                ->where('group_user.user_id', '=', $userId)
                                ->where('group_user.group_id', '=', $group->id)
                                // ->whereNull('group_user.status')
                                //whereNull is not usefull
                                ->get();
           $array2 = DB::table('groups')

          //                     //all the group owned by somebodyelse
                              ->where('groups.owner', '!=', $userId)

                              ->get();

              if (empty($array[0]) && !empty($array2[0])) {

                                  $tab[] = $group;
              }
              $array = '';
              $array2= '';
          }
          $groupsWait = \App\Group::join('group_user', 'group_user.group_id', '=', 'groups.id')
                                    ->where('group_user.user_id', '=', $userId)
                                    ->where('group_user.status', 0)
                                    ->get();

      }

          return view('home',
          ['groups' => $tab, 'groupsWait' => $groupsWait]
        );
      }

}
