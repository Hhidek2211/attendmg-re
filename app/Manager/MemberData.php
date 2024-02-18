<?php 

namespace App\Manager;

use App\Models\User;
use App\Models\TodayData;
use App\Models\OverTime;

class MemberData {

    function __construct($user) {
        $this->manager = $user;
    }
    
    //管理者の使うメンバー情報の取得.
    public function get_memberdatas() {
        $members = User::where('manager_id', $this->manager->id)->get();
        $datas = array();
        foreach($members as $member) {
            $now = TodayData::get_now($member->id);
            $over = OverTime::get_todaydata($member->id);
            $datas[] = [
                'id'=> $member->id,
                'name'=> $member->name,
                'now_type'=> $now['type'],
                'now_time'=> $now['time'],
                'over_hour'=> $over->hour,
            ];
        }
        return $datas;
    }
}