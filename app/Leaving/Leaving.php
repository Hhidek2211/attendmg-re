<?php

namespace App\Leaving;

//休日時のデータテンプレートを返す
class Leaving {

    public static function set_values() {
        $datas = [
            'isleave'=> True,
            'start' => '00:00:00',
            'end'=> '00:00:00',
            'break'=> '00:00:00',
            'hour'=> '00:00:00',
            'over'=> '00:00:00',
        ];

        return $datas;
    }
}