<?php
require 'BaseCal.php';

class MyCal extends BaseCal
{
    /**
     * 引数の年と月のフォーマットチェックを行う。
     * 年は0～9999の4桁以内の数値。
     * 月は1～12の2桁以内の数値。
     *
     * @param int $year 表示するカレンダーの年。
     * @param int $year 表示するカレンダーの月。
     * @return bool フォーマットが正常であればtrue, 異常であればfalse。
     */
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

    /**
     * 指定した年月のカレンダーを表示する。
     *
     * @param int $year 表示するカレンダーの年。
     * @param int $year 表示するカレンダーの月。
     * @return 無し。
     */
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

        echo '<table border="1" cellpadding="5" cellspacing="0" align="center">';
            // カレンダーを表示
            echo '<tr>';
                for ($i = 0; $i <= 6; $i++) {
                    echo '<td align="center" bgcolor="#eeeeee">'.$strWeek[$i].'</td>';
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
    
    /**
     * 現在表示しているカレンダーの前月の年・月を計算する。
     *
     * @param int $year 現在表示しているカレンダーの年。
     * @param int $month 現在表示しているカレンダーの月。
     * @return array|int 前月の年・月。
     */
    public function preMonth($year, $month)
    {
        $monthBefore = $month - 1;
        $yearBefore = $year;
        // 前月が0月になると、年を1年戻して12月に変換
        if ($monthBefore === 0) {
            $monthBefore = 12;
            $yearBefore = $year - 1;
        }
        return array($yearBefore, $monthBefore);
    }
    
    /**
     * 現在表示しているカレンダーの来月の年・月を計算する。
     *
     * @param int $year 現在表示しているカレンダーの年。
     * @param int $month 現在表示しているカレンダーの月。
     * @return array|int 来月の年・月。
     */
    public function nextMonth($year, $month)
    {
        $monthAfter = $month + 1;
        $yearAfter = $year;
        // 来月が13月になると、年を1年上げて1月に変換
        if ($monthAfter === 13) {
            $monthAfter = 1;
            $yearAfter = $year + 1;
        }
        return array($yearAfter, $monthAfter);
    }
}

