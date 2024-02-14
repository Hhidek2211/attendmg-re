<?php

namespace App\Attendance;



class AttendButton {

    function __construct($type) {
        switch($type) {
            case 0:
                $this->html = $this->leaving();
                break;
            case 1:
                $this->html = $this->at_work();
                break;
            case 2:
                $this->html = $this->breaking();
                break; 
        }   
    }

    //最新の状況に合わせた出席ボタンの出力の切り替え
    public function leaving() {
        $html[] = '<div class="container mx-auto w-2/3 h-full text-center border">';
        $html[] = '<p class="text-lg text-gray-700 pt-1">タイムカードメニュー</p>';
        $html[] = '<div class="relative border rounded-full w-3/4 mx-auto">';
        $html[] = '<a href="/dashboard" class="absolute top-0 left-0 w-full h-full cursor-pointer mx-auto"></a>';
        $html[] = '<div class="mx-auto">出勤</div>';
        $html[] = '</div>';
        $html[] = '</div>';

        return $html;
    }

    public function at_work() {
        $html[] = '<div class="container mx-auto w-2/3 h-full text-center border">';
        $html[] = '<p class="text-lg text-gray-700 pt-1">タイムカードメニュー</p>';
        $html[] = '<div class="relative border rounded-full w-3/4 mx-auto">';
        $html[] = '<a href="/dashboard" class="absolute top-0 left-0 w-full h-full cursor-pointer mx-auto"></a>';
        $html[] = '<div class="mx-auto">休憩</div>';
        $html[] = '</div>';
        $html[] = '<div class="relative border rounded-full w-3/4 mx-auto mt-2">';
        $html[] = '<a href="/dashboard" class="absolute top-0 left-0 w-full h-full cursor-pointer mx-auto"></a>';
        $html[] = '<div class="mx-auto">退勤</div>';
        $html[] = '</div>';
        $html[] = '</div>';

        return $html;
    }

    public function breaking() {
        $html[] = '<div class="container mx-auto w-2/3 h-full text-center border">';
        $html[] = '<p class="text-lg text-gray-700 pt-1">タイムカードメニュー</p>';
        $html[] = '<div class="relative border rounded-full w-3/4 mx-auto">';
        $html[] = '<a href="/dashboard" class="absolute top-0 left-0 w-full h-full cursor-pointer mx-auto"></a>';
        $html[] = '<div class="mx-auto">勤務再開</div>';
        $html[] = '</div>';
        $html[] = '</div>';       
        
        return $html;
    }

    public function render() {
        return implode("", $this->html);
    }
}