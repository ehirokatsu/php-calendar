<?php
abstract class BaseCal
{
    /**
     * 引数の年と月のフォーマットチェックを行う。
     * 年は0～9999の4桁以内の数値。
     * 月は1～12の2桁以内の数値。
     *
     * @param int $year 表示するカレンダーの年。
     * @param int $month 表示するカレンダーの月。
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
     * @param int $month 表示するカレンダーの月。
     */
    abstract function showCal($year, $month);
}

