<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Manager\MemberData;
use App\Models\User;

class ManagerController extends Controller
{
    public function manager(): View
    {
        $manager = Auth::user();
        $memberdatas = new MemberData(Auth::user());
        $memberdatas = $memberdatas->get_memberdatas();
        //dd($memberdatas);
        return view('manager.managerDashboard', ["memberdatas"=> $memberdatas, "manager"=> $manager]);
    }
    
    public function setting(): View
    {
        $manager = Auth::user();
        $users = User::get();

        return view('manager.membersetting', ["manager"=> $manager, "users"=> $users]);
    }

    public function regester_member(Request $request)
    {   
        //dump($request);
        $length = count($request->id);
        
        for($i=0; $i < $length; $i++){
            if($request->member[$i]) {
                $user = User::where('id', $request->user_id[$i])->first();
                $user->update([
                    'manager_id'=> Auth::id()
                ]);
            }
        }
        //dd(User::get());

        return redirect(route('mg.dashboard'));
    }

    public function memberinfo(User $user): View
    {
        $calender = CalenderController::get_calender();
        $today = TodayDataController::show_todayDatas($user->id);

        return view('manager.memberinfo', ["calender" => $calender, "today"=> $today, "user"=> $user]);
    }
}
