<?php
abstract class BaseCal
{
    // 日付のフォーマットチェック関数
    abstract function validateDate($year, $month);

    // カレンダー表示関数
    abstract function showCal($year, $month);
}

