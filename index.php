<!DOCTYPE html PUBLIC "-// W3C// DTD XHTML 1.0 Transitional// EN"
 "http:// www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http:// www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>PHP Calendar</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
    require 'cal.php';

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
    $myCal->showCal($year, $month);

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
    <form name="now" method="GET" action="index.php">
    <input type="submit" value="今月">
    </form>
</div>

<br>

<table>
    <tr>
        <td>
            <form name="before" method="GET" action="index.php">
            <input type="hidden" name="year" value="<?php echo $yearBefore; ?>">
            <input type="hidden" name="month" value="<?php echo $monthBefore; ?>">
            <input type="submit" value="前月">
            </form>
        </td>
        
        <td></td>
        
        <td>
            <form name="after" method="GET" action="index.php">
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

