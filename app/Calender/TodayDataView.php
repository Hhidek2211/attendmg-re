<?php

namespace App\Calender;



class TodayDataView {

  public function render() {

    $html[] = '<table class="mx-auto w-4/5">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th class="w-3/5">時刻</th>';
    $html[] = '<th class="w-2/5">内容</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';

    $html[] = '</tbody>';
    $html[] = '</table>';    

    return implode("", $html);
  }
}