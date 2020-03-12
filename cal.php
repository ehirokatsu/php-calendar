<!DOCTYPE html PUBLIC "-// W3C// DTD XHTML 1.0 Transitional// EN"
 "http:// www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http:// www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>PHP Calendar</title>
<style>
.center {
    text-align: center;
    margin-left: auto;
    margin-right: auto;
}
</style>
</head>
<body>
<?php

class MyCal
{
    // 年の変数
    public $year = 0;
    // 月の変数
    public $month = 0;

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
    public function ShowCal($year, $month)
    {
        // 表示するカレンダーの年月を表示
        echo '<div class="center">'.$year.'年'.$month.'月</div><br>';

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
                    echo '<td align="center" bgcolor="#eeeeee">'.$strWeek[$i].'</td>    ';
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


    // 今月の情報を取得
    $date = new DateTime();
    // カレンダークラスのインスタンス生成
    $myCal = new MyCal();

    // 年は0～9999、月は1～12かチェック
    if (isset($_GET["year"]) && isset($_GET["month"]) && $myCal->validateDate($_GET["year"], $_GET["month"])) {
        $year = (int)$_GET["year"];
        $month = (int)$_GET["month"];
    // 上記以外の場合は今月のカレンダーを表示
    } else {
        $year = (int)$date->format('Y');
        $month = (int)$date->format('n');
    }

    // カレンダーを表示する
    $myCal->ShowCal($year, $month);

    // 前月ボタン押下時の準備
    $monthBefore = $month - 1;
    $yearBefore = $year;
    // 前月が0月になると、年を1年戻して12月に変換
    if ($monthBefore === 0) {
        $monthBefore = 12;
        $yearBefore = $year - 1;
    }

    // 来月ボタン押下時の準備
    $monthAfter = $month + 1;
    $yearAfter = $year;
    // 来月が13月になると、年を1年上げて1月に変換
    if ($monthAfter === 13) {
        $monthAfter = 1;
        $yearAfter = $year + 1;
    }

?>

<br>

<div class="center">
    <form name="now" method="GET" action="cal.php">
    <input type="submit" value="今月">
    </form>
</div>

<br>

<table align="center">
    <tr>
        <td>
            <form name="before" method="GET" action="cal.php">
            <input type="hidden" name="year" value="<?php echo $yearBefore; ?>">
            <input type="hidden" name="month" value="<?php echo $monthBefore; ?>">
            <input type="submit" value="前月">
            </form>
        </td>
        
        <td></td>
        
        <td>
            <form name="after" method="GET" action="cal.php">
            <input type="hidden" name="year" value="<?php echo $yearAfter; ?>">
            <input type="hidden" name="month" value="<?php echo $monthAfter; ?>">
            <input type="submit" value="来月">
            </form>
        </td>
    </tr>
</table>

</p>
</body>
</html>

