<?php

namespace App\Calender;

use Carbon\Carbon;
use App\Models\TodayData;


class TodayDataView {


  function __construct($userId) {
    $this->user = $userId;
  }

  public function format_type($data) {
    $answer = ['退勤', '出勤', '休憩開始', '休憩終了'];
    return $answer[$data];
  }

  //今日の出勤記録データ表の作成
  public function render() {
    $datas = TodayData::get_userdata($this->user);
    $i = 0;

    $html[] = '<table class="mx-auto md:w-4/5">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th class="px-32">時刻</th>';
    $html[] = '<th class="px-20">内容</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    foreach($datas as $data) {
      $type = $this->format_type($data->data_type);
      $time = new Carbon($data->time);
      $time = $time->format('G:i:s');

      $html[] = '<tr>';
      $html[] = '<td>'.$time.'</td>';
      $html[] = '<td>'.$type.'</td>';
      $html[] = '</tr>';
      $i++;
    }
    for($i; $i<10; $i++) {
      $html[] = '<tr>';
      $html[] = '<td></td>';
      $html[] = '<td></td>';
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';    

    return implode("", $html);
  }

}