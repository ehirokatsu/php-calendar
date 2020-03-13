<?php
    require 'abstract_cal.php';

    class MyCal extends BaseCal
    {
        // 日付のフォーマットチェック関数
        public function validateDate($year, $month)
        {
            // 年は4桁、月は2桁になるよう0埋めする
            $year = sprintf('%04s', $year);
            $month = sprintf('%02s', $month);
            
            $date = "{$year}-{$month}-01";
            $format = 'Y-m-d';
            $checkDate = DateTime::createFromFormat($format, $date);

            if ($checkDate && ($checkDate->format($format) == $date)) {
                return true;
            } else {
                return false;
            }
        }

        // カレンダー表示関数
        public function showCal($year, $month)
        {
            // 表示するカレンダーの年月を表示
            echo '<center>'.$year.'年'.$month.'月</center><br>';

            // 表示するカレンダーの1日を取得
            $firstDate = new DateTime("{$year}-{$month}-1");
            
            // 月初めの曜日
            $dayOfWeek = $firstDate->format('w');
            
            // 月の日数
            $dayMax = $firstDate->format('t');
            
            // カレンダー表示用の曜日
            $strWeek= ["日", "月", "火", "水", "木", "金", "土"];

            echo '<table border="1" cellpadding="5" cellspacing="0" align="center">    ';
                // カレンダーを表示
                echo '<tr>';
                    for ($i = 0; $i <= 6; $i++) {
                        echo '<td align="center" bgcolor="#eeeeee">'.$strWeek[$i].'    </td>    ';
                    }
                echo '</tr>';

                // 日にち用カウンタ
                $day = 1;
                
                echo '<tr>';
                // カレンダー1行目の出力
                for ($j = 0; $j <= 6; $j++) {
                    // 1日まではパディング
                    if ($j < $dayOfWeek) {
                        echo '<td></td>';
                    // 1日以降のdayを入力
                    } else {
                        echo '<td align="center">'.$day.'</td>';
                        $day = $day + 1;
                    }
                }
                echo '</tr>';
                // カレンダー2行目以降の出力
                while ($day + 7 <= $dayMax + 1) {
                    echo '<tr>';
                    for ($j = 0; $j <= 6; $j++){
                        echo '<td align="center">'.$day.'</td>';
                        $day = $day + 1;
                    }
                    echo '</tr>';
                }
                // 最終日以降パディングが必要なら出力
                if ($day < $dayMax + 1) {
                    echo '<tr>';
                    for ($j = 0; $j <= 6; $j++) {
                        // 月末まで
                        if ($day <= $dayMax) {
                            echo '<td align="center">'.$day.'</td>';
                            $day = $day + 1;
                        // 月末以降をパディング
                        } else {
                            echo '<td></td>';
                        }
                    }
                    echo '</tr>';
                }
            echo '</table>';
        }
    }

