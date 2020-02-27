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
    // 今月の情報を取得
    $date = new DateTime();

    // GETパラメータのチェック
    // 年は1～9999の数値
    // 月は1～12までの数値
    if (
        isset($_GET["year"]) &&
        isset($_GET["month"])&&
        preg_match('/^[0-9]{0,4}$/', $_GET["year"]) && 
        $_GET["year"] > 0 && 
        preg_match('/^[1-9]$|^0[1-9]$|^1[0-2]$/', $_GET["month"])
        ) {
            $year = (int)$_GET["year"];
            $month = (int)$_GET["month"];
    // 上記以外の場合は今月のカレンダーを表示する
    } else {
        $year = (int)$date->format('Y');
        $month = (int)$date->format('n');
    }

    // 表示するカレンダーの年月を表示
    echo '<div class="center">'.$year.'年'.$month.'月</div><br>';

    $firstDate = new DateTime("{$year}-{$month}-1");
    // 月初めの曜日
    $dayOfWeek = $firstDate->format('w');
    // 月の日数
    $dayMax = $firstDate->format('t');


    echo '<table border="1" cellpadding="5" cellspacing="0" align="center">';
        // カレンダーを表示
        echo '<tr>';
            echo '<td align="center" bgcolor="#eeeeee">日</td>';
            echo '<td align="center" bgcolor="#eeeeee">月</td>';
            echo '<td align="center" bgcolor="#eeeeee">火</td>';
            echo '<td align="center" bgcolor="#eeeeee">水</td>';
            echo '<td align="center" bgcolor="#eeeeee">木</td>';
            echo '<td align="center" bgcolor="#eeeeee">金</td>';
            echo '<td align="center" bgcolor="#eeeeee">土</td>';
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
        for (; $day+7 <= $dayMax+1; ) {
            echo '<tr>';
            for ($j = 0; $j <= 6; $j++){
                echo '<td align="center">'.$day.'</td>';
                $day = $day + 1;
            }
            echo '</tr>';
        }
        // 最終日以降パディングが必要なら出力
        if ($day < $dayMax+1) {
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


    // 前月ボタン押下時の準備
    $monthBefore = $month -1;
    $yearBefore = $year;
    // 前月が0月になると、年を1年戻して12月にする
    if ($monthBefore == 0) {
        $monthBefore =12;
        $yearBefore = $year - 1;
    }

    // 来月ボタン押下時の準備
    $monthAfter = $month +1;
    $yearAfter = $year;
    // 来月が13月になると、年を1年上げて1月にする
    if ($monthAfter == 13) {
        $monthAfter = 1;
        $yearAfter = $year + 1;
    }
?>

<br>

<div class="center">
    <form name="now" method="GET" action="cal2.php">
    <input type="submit" value="今月">
    </form>
</div>

<br>

<table align="center">
    <tr>
        <td>
            <form name="before" method="GET" action="cal2.php">
            <input type="hidden" name="year" value="<?php echo $yearBefore; ?>">
            <input type="hidden" name="month" value="<?php echo $monthBefore; ?>">
            <input type="submit" value="前月">
            </form>
        </td>
        
        <td></td>
        
        <td>
            <form name="after" method="GET" action="cal2.php">
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

